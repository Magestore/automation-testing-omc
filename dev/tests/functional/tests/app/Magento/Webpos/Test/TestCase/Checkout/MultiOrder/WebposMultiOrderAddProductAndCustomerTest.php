<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 07/12/2017
 * Time: 14:10
 */

namespace Magento\Webpos\Test\TestCase\Checkout\MultiOrder;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Mtf\Fixture\FixtureFactory;
/**
 * Class WebposMultiOrderAddProductAndCustomerTest
 * @package Magento\AssertWebposCheckGUICustomerPriceCP54\Test\TestCase\CategoryRepository\MultiOrder
 */
class WebposMultiOrderAddProductAndCustomerTest extends Injectable
{
    /**
     * AssertWebposCheckGUICustomerPriceCP54 Index page.
     *
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * @param WebposIndex $webposIndex
     * @param FixtureFactory $fixtureFactory
     * @return void
     */
    public function __inject(
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
    }

    /**
     * Login AssertWebposCheckGUICustomerPriceCP54 group test.
     *
     * @return void
     */
    public function test($products, FixtureFactory $fixtureFactory, $orderNumber)
    {
        $staff = $this->objectManager->create(
            '\Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();
        $i = 0;
        foreach ($products as $product) {
            $products[$i] = $fixtureFactory->createByCode('catalogProductSimple', ['dataset' => $product]);
            $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
            $this->webposIndex->getCheckoutProductList()->search($products[$i]->getSku());
            $i++;
        }
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();

        $this->webposIndex->getCheckoutWebposCart()->getIconChangeCustomer()->click();
        $this->webposIndex->getCheckoutChangeCustomer()->getFirstCustomer()->click();

        $this->webposIndex->getCheckoutCartHeader()->getAddMultiOrder()->click();
        $this->webposIndex->getCheckoutPlaceOrder()->waitCartLoader();
        $this->webposIndex->getCheckoutCartHeader()->getMultiOrderItem($orderNumber)->click();
        $this->webposIndex->getCheckoutPlaceOrder()->waitCartLoader();
        return ['products' => $products];
    }
}