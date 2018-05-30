<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 11/12/2017
 * Time: 15:18
 */

namespace Magento\Webpos\Test\TestCase\Checkout\MultiOrder;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Checkout\CheckGUI\AssertWebposCheckoutPagePlaceOrderPageSuccessVisible;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposMultiOrderCheckoutOn2ndCartTest
 * @package Magento\WebposCheckGUICustomerPriceCP54EntityTest\Test\TestCase\CategoryRepository\MultiOrder
 *
 * Precondition:
 * "1. Login webpos as a staff
 * 2. Click on add multi order icon"
 *
 * Steps:
 * "1. Add some products  to 2nd cart
 * 2. Place order 2nd cart"
 *
 * Acceptance:
 * "1. Place order successfully
 * 2. In cart page, there is only 1st cart, 2nd cart is deleted"
 *
 */
class WebposMultiOrderCheckoutOn2ndCartTest extends Injectable
{
    /**
     * WebposCheckGUICustomerPriceCP54EntityTest Index page.
     *
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * @var AssertWebposCheckoutPagePlaceOrderPageSuccessVisible
     */
    protected $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;

    /**
     * @param WebposIndex $webposIndex
     * @return void
     */
    public function __inject(
        WebposIndex $webposIndex,
        AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
    )
    {
        $this->webposIndex = $webposIndex;
        $this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible = $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;
    }

    /**
     * LoginTest WebposCheckGUICustomerPriceCP54EntityTest group test.
     *
     * @return void
     */
    public function test($orderNumber, $products, FixtureFactory $fixtureFactory)
    {
        $staff = $this->objectManager->create(
            '\Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();
        $this->webposIndex->getCheckoutCartHeader()->getAddMultiOrder()->click();
        $this->webposIndex->getCheckoutPlaceOrder()->waitCartLoader();
        $this->webposIndex->getCheckoutCartHeader()->getMultiOrderItem($orderNumber)->click();
        $this->webposIndex->getCheckoutPlaceOrder()->waitCartLoader();
        $i = 0;
        foreach ($products as $product) {
            $products[$i] = $fixtureFactory->createByCode('catalogProductSimple', ['dataset' => $product]);
            $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
            $this->webposIndex->getCheckoutProductList()->search($products[$i]->getSku());
            $i++;
        }
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();

        sleep(1);
        $this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(1);
        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();

        //Assert Place Order Success
        $this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible->processAssert($this->webposIndex);
        sleep(1);
        $this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
    }
}