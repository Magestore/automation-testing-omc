<?php
/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 1/12/2018
 * Time: 8:29 AM
 */

namespace Magento\Webpos\Test\TestCase\Checkout\CartPage\CustomSale;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Webpos\Test\Constraint\Checkout\CheckGUI\AssertWebposCheckoutPagePlaceOrderPageSuccessVisible;
use Magento\Webpos\Test\Constraint\Checkout\CartPage\CustomSale\AssertWebposCustomSaleShippingMethodSectionShow;
/**
 *  * Preconditions:
 * 1. Login webpos by a  staff
 * 2. Add custom product to cart with shippable: on
 *
 * Step:
 * 1. Place order as manual product
 */
/**
 * Class WebposCustomSaleShippableOnCP82EntityTest
 * @package Magento\Webpos\Test\TestCase\Checkout\CartPage\CustomSale
 */
class WebposCustomSaleShippableOnCP82EntityTest  extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;
    /**
     * @var
     */
    protected $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;
    /**
     * @var
     */
    protected  $assertWebposCustomSaleShippingMethodSectionShow;

    /**
     * @param WebposIndex $webposIndex
     * @param AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
     * @param AssertWebposCustomSaleShippingMethodSectionShow $assertWebposCustomSaleShippingMethodSectionShow
     */
    public function __inject(
        WebposIndex $webposIndex,
        AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible,
        AssertWebposCustomSaleShippingMethodSectionShow $assertWebposCustomSaleShippingMethodSectionShow
    )
    {
        $this->webposIndex = $webposIndex;
        $this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible = $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;
        $this->assertWebposCustomSaleShippingMethodSectionShow = $assertWebposCustomSaleShippingMethodSectionShow;
    }

    /**
     * @param $productName
     * @param $productDescription
     */
    public function test($productName, $price)
    {
        $staff = $this->objectManager->create(
            '\Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $this->webposIndex->getCheckoutProductList()->getCustomSaleButton()->click();
        $this->webposIndex->getCheckoutCustomSale()->getProductNameInput()->setValue($productName);
        // number field price keyboard
        $this->webposIndex->getCheckoutCustomSale()->getProductPriceInput()->setValue($price);
        $this->webposIndex->getCheckoutCustomSale()->getShipAbleCheckbox()->click();
        $this->webposIndex->getCheckoutCustomSale()->getAddToCartButton()->click();
        //CategoryRepository
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        // assert shippable
        $this->assertWebposCustomSaleShippingMethodSectionShow->processAssert($this->webposIndex);

        //Select cash and place order
        $this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();

        //Assert Place Order Success
        $this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible->processAssert($this->webposIndex);

        $this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        //Click Order History
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->ordersHistory();
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        sleep(3);
        $this->webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();
    }
}