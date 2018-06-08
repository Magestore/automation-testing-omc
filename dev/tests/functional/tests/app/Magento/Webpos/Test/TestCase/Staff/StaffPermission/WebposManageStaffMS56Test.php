<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 12/02/2018
 * Time: 09:14
 */

namespace Magento\Webpos\Test\TestCase\Staff\StaffPermission;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\WebposRole;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Webpos\Test\Constraint\Adminhtml\Staff\Permission\AssertEditDiscountCustomPrice;

/**
 * Staff Permission
 * Testcase MS56 - Edit custom price and discount for whole cart
 *
 * Precondition:
 * 1. Go to backend >   Sales > Manage Roles
 * 2. Add a new role:
 * - Maximum discount percent(%): blank
 * - Select all permission
 * - Select a staff A
 *
 * Steps
 * 1. Login webpos by the staff A
 * 2. Add some  products to cart
 * 3. Edit custom price of any product :80% of original price
 * 4. Add discount for whole cart: 100%
 * 5. Place order as manual
 *
 * Acceptance Criteria
 * 3. Edit custom price successfully
 * 4. Add discount for whole cart successfully
 * 5. Place order successfully
 *
 * Class WebposManageStaffMS56Test
 * @package Magento\Webpos\Test\TestCase\Staff\StaffPermission
 */
class WebposManageStaffMS56Test extends Injectable
{

    /**
     * @var WebposIndex $webposIndex
     */
    private $webposIndex;

    /**
     * @var AssertEditDiscountCustomPrice $assertEditDiscountCustomPrice
     */
    protected $assertEditDiscountCustomPrice;

    public function __prepare()
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'have_shipping_method_on_webpos_CP197,create_section_before_working_no']
        )->run();
    }

    /**
     * @param WebposIndex $webposIndex
     * @param AssertEditDiscountCustomPrice $assertEditDiscountCustomPrice
     */
    public function __inject(
        WebposIndex $webposIndex,
        AssertEditDiscountCustomPrice $assertEditDiscountCustomPrice
    )
    {
        $this->webposIndex = $webposIndex;
        $this->assertEditDiscountCustomPrice = $assertEditDiscountCustomPrice;
    }

    /**
     * @param WebposRole $webposRole
     * @param $products
     * @param $priceCustom
     * @param $discount
     * @return array
     */
    public function test(WebposRole $webposRole, $products, $priceCustom, $discount)
    {
        //Create role and staff for role
        $webposRole->persist();
        $staff = $webposRole->getDataFieldConfig('staff_id')['source']->getStaffs()[0];

        //Create product
        $products = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
            ['products' => $products]
        )->run();
        $product1 = $products[0]['product'];
        $product2 = $products[1]['product'];

        //Login Webpos
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposByStaff',
            [
                'staff' => $staff,
                'hasOpenSession' => null,
                'hasWaitOpenSessionPopup' => null
            ]
        )->run();
        $this->webposIndex->getMainContent()->waitLoader();
        //Add products to cart
        $this->webposIndex->getCheckoutProductList()->search($product1->getName());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        sleep(1);
        $this->webposIndex->getCheckoutProductList()->search($product2->getName());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        sleep(1);

        //Click to first product name > Discount tab > Input amount greater than original
        $this->webposIndex->getCheckoutCartFooter()->waitForElementVisible('.checkout');
        $this->webposIndex->getCheckoutCartItems()->getFirstCartItem()->click();
        $this->webposIndex->getCheckoutProductEdit()->getDiscountButton()->click();
        $this->webposIndex->getCheckoutProductEdit()->getPercentButton()->click();
        $this->webposIndex->getCheckoutProductEdit()->getAmountInput()->setValue($priceCustom);
        $this->webposIndex->getCheckoutProductEdit()->getClosePopupCustomerSale()->click();
        $this->webposIndex->getCheckoutCartFooter()->waitForElementVisible('.checkout');

        //Assert custom price
        $this->assertEditDiscountCustomPrice->processAssert($this->webposIndex, 80, 1);

        //Cart
        $this->webposIndex->getCheckoutCartFooter()->waitForElementVisible('.checkout');
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(1);
        $this->webposIndex->getMsWebpos()->waitForElementNotVisible('#webpos_checkout > div.indicator');

        //Click on [Add discount] > on Discount tab, add dicount for whole cart (type: %)
        $total = $this->webposIndex->getCheckoutCartFooter()->getTotal();
        while (!$this->webposIndex->getCheckoutDiscount()->isDisplayPopup()) {
            $this->webposIndex->getCheckoutCartFooter()->getAddDiscount()->click();
        }
        $this->webposIndex->getCheckoutDiscount()->clickDiscountButton();
        $this->webposIndex->getCheckoutDiscount()->setTypeDiscount('%');
        $this->webposIndex->getCheckoutDiscount()->setNumberDiscount($discount);
        $this->webposIndex->getCheckoutDiscount()->clickDiscountApplyButton();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(1);

        //PlaceOrder
        $this->webposIndex->getCheckoutCartFooter()->waitForElementVisible('#checkout_button');
        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $this->webposIndex->getCheckoutPlaceOrder()->waitCartLoader();
        sleep(1);

        //Get orderId
        $orderId = $this->webposIndex->getCheckoutSuccess()->getOrderId()->getText();
        $orderId = ltrim($orderId, '#');
        $this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
        sleep(1);
        return [
            'orderId' => $orderId,
            'shippingDescription' => 'Flat Rate - Fixed',
            'discount' => 100,
            'total' => $total
        ];
    }
}

