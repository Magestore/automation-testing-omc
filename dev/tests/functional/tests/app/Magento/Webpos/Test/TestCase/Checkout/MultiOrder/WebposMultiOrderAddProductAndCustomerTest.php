<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 07/12/2017
 * Time: 14:10
 */

namespace Magento\Webpos\Test\TestCase\Checkout\MultiOrder;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposMultiOrderAddProductAndCustomerTest
 * @package Magento\AssertWebposCheckGUICustomerPriceCP54\Test\TestCase\CategoryRepository\MultiOrder
 *
 * Precondition:
 * 1. Login Webpos as a staff
 *
 * Steps:
 * "1. Add a product and customer to cart
 * 2. Click on add multi order icon (icon +)"
 *
 * Acceptance:
 * "1. Open 2 carts
 * 2. 1st cart contains product and customer which added in step 1 of [Steps] column "
 *
 */
class WebposMultiOrderAddProductAndCustomerTest extends Injectable
{
    /**
     * AssertWebposCheckGUICustomerPriceCP54 Index page.
     *
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * @param WebposIndex $webposIndex
     * @return void
     */
    public function __inject(
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
    }

    /**
     * @param $products
     * @param FixtureFactory $fixtureFactory
     * @param $orderNumber
     * @return array
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
        sleep(3);
        $this->webposIndex->getCheckoutCartHeader()->getAddMultiOrder()->click();
        $this->webposIndex->getCheckoutPlaceOrder()->waitCartLoader();
        $this->webposIndex->getCheckoutCartHeader()->getMultiOrderItem($orderNumber)->click();
        $this->webposIndex->getCheckoutPlaceOrder()->waitCartLoader();
        return ['products' => $products];
    }
}