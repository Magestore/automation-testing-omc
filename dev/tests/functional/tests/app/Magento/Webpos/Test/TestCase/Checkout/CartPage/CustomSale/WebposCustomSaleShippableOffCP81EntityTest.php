<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 1/11/2018
 * Time: 4:33 PM
 */

namespace Magento\Webpos\Test\TestCase\Checkout\CartPage\CustomSale;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Checkout\CartPage\CustomSale\AssertWebposCustomSaleShippingMethodSectionHidden;
use Magento\Webpos\Test\Constraint\Checkout\CheckGUI\AssertWebposCheckoutPagePlaceOrderPageSuccessVisible;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposCustomSaleShippableOffCP81EntityTest
 * @package Magento\Webpos\Test\TestCase\Cart\CartPage\CustomSale
 *
 * Preconditions:
 * 1. LoginTest webpos by a  staff
 * 2. Add custom product to cart with shippable: off
 *
 * Steps:
 * 1. Place order as manual product
 *
 * Acceptance:
 * "1. Shipping method section will be hidden on Checkout page
 * 2. Order is checkout successfully and save in Order list"
 *
 */
class WebposCustomSaleShippableOffCP81EntityTest extends Injectable
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
    protected $assertWebposCustomSaleShippingMethodSectionHidden;

    /**
     * @param WebposIndex $webposIndex
     * @param AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
     * @param AssertWebposCustomSaleShippingMethodSectionHidden $assertWebposCustomSaleShippingMethodSectionHidden
     */
    public function __inject(
        WebposIndex $webposIndex,
        AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible,
        AssertWebposCustomSaleShippingMethodSectionHidden $assertWebposCustomSaleShippingMethodSectionHidden
    )
    {
        $this->webposIndex = $webposIndex;
        $this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible = $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;
        $this->assertWebposCustomSaleShippingMethodSectionHidden = $assertWebposCustomSaleShippingMethodSectionHidden;
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
        sleep(2);
        $this->webposIndex->getCheckoutCustomSale()->getAddToCartButton()->click();
        //CategoryRepository
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        // assert shippable
        $this->assertWebposCustomSaleShippingMethodSectionHidden->processAssert($this->webposIndex);

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
        $this->webposIndex->getMsWebpos()->waitOrdersHistoryVisible();
        $this->webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();
    }
}