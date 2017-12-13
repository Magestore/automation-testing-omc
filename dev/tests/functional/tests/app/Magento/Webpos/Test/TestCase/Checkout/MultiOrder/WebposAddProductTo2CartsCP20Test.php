<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 07/12/2017
 * Time: 14:53
 */

namespace Magento\Webpos\Test\TestCase\Checkout\MultiOrder;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Mtf\Fixture\FixtureFactory;
/**
 * Class WebposAddProductTo2CartsCP20Test
 * @package Magento\AssertWebposCheckGUICustomerPriceCP54\Test\TestCase\Checkout\MultiOrder
 */
class WebposAddProductTo2CartsCP20Test extends Injectable
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
     * @param FixtureFactory $fixtureFactory
     * @return void
     */
    public function test($products, FixtureFactory $fixtureFactory, $orderNumber)
    {
        $staff = $this->objectManager->create(
            '\Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $this->webposIndex->getCheckoutCartHeader()->getAddMultiOrder()->click();
        $this->webposIndex->getCheckoutPlaceOrder()->waitCartLoader();
        $j = 0;
        foreach ($products as $product) {
            $products[$j] = $fixtureFactory->createByCode('catalogProductSimple', ['dataset' => $product]);
            $j++;
        }
        $k=0;
        for ($i=1; $i<=2; $i++) {
            $this->webposIndex->getCheckoutCartHeader()->getMultiOrderItem($i)->click();
            $this->webposIndex->getCheckoutPlaceOrder()->waitCartLoader();
            $this->webposIndex->getCheckoutPlaceOrder()->waitCartLoader();
            for ($j=$k;$j<2*$i; $j++) {
                $this->webposIndex->getCheckoutProductList()->search($products[$j]->getSku());
                $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
            }
            $k += $j;
        }
        sleep(3);
        for ($i=1; $i<=3; $i++) {
            for ($j=1; $j<=2; $j++) {
                $this->webposIndex->getCheckoutCartHeader()->getMultiOrderItem($j)->click();
                for ($p=1; $p<=3; $p++) {
                    $this->webposIndex->getCheckoutPlaceOrder()->waitCartLoader();
                    $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
                }
                sleep(3);
            }
            sleep(5);
        }
        return ['products' => $products];
    }
}