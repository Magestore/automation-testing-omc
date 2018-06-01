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

/**
 * Staff Permission
 * Testcase MS51 - Discount whole cart
 *
 * Precondition:
 * 1. Go to backend > Sales > Manage Roles
 * 2. Add a new role:
 * - Maximum discount percent(%): 50
 * - Select all permission
 * - Select a staff A
 *
 * Steps
 * 1. Login webpos by staff A
 * 2. Add some  products to cart
 * 3. Add discount (type fixed) with amount greater than 50% of total
 * (Ex: total order = 100$, add discount = 60$)
 * 4. Place order
 *
 * Acceptance Criteria
 * 4.
 * - Apply discount successfully with maxinum discount is 50% of total
 * (maximum discount = 50$)
 * - Place order successfully
 *
 * Class WebposManageStaffMS51Test
 * @package Magento\Webpos\Test\TestCase\Staff\StaffPermission
 */
class WebposManageStaffMS51Test extends Injectable
{

    /**
     * @var WebposIndex
     */
    private $webposIndex;

    public function __prepare()
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'have_shipping_method_on_webpos_CP197']
        )->run();
    }

    /**
     * Inject WebposIndex pages.
     *
     * @param $webposIndex
     * @return void
     */
    public function __inject(
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
    }

    /**
     * @param WebposRole $webposRole
     * @param $products
     * @param $discount
     * @return array
     */
    public function test(WebposRole $webposRole, $products, $discount)
    {
        //Create role and staff for role
        $webposRole->persist();
        $dataStaff = $webposRole->getDataFieldConfig('staff_id')['source']->getStaffs()[0]->getData();

        //Create product
        $products = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
            ['products' => $products]
        )->run();
        $product1 = $products[0]['product'];
        $product2 = $products[1]['product'];

        //LoginTest
        $this->loginWebpos($this->webposIndex, $dataStaff['username'], $dataStaff['password']);

        //Add products to cart
        $this->webposIndex->getCheckoutProductList()->search($product1->getName());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        sleep(1);
        $this->webposIndex->getCheckoutProductList()->search($product2->getName());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        sleep(1);

        //Click on [Add discount] > on Discount tab, add dicount for whole cart (type: $)
        while (!$this->webposIndex->getCheckoutDiscount()->isDisplayPopup()) {
            $this->webposIndex->getCheckoutCartFooter()->getAddDiscount()->click();
        }
        $this->webposIndex->getCheckoutDiscount()->clickDiscountButton();
        $this->webposIndex->getCheckoutDiscount()->setTypeDiscount('$');
        $this->webposIndex->getCheckoutDiscount()->setDiscountAmount($discount);
        $this->webposIndex->getCheckoutDiscount()->clickDiscountApplyButton();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $this->webposIndex->getCheckoutCartFooter()->waitForElementVisible('.checkout');
        sleep(1);

        //Cart
        $this->webposIndex->getCheckoutCartFooter()->waitForElementVisible('.checkout');
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(3);
//        $this->webposIndex->getMsWebpos()->waitForElementVisible('#webpos_checkout > div.indicator');
        $this->webposIndex->getMsWebpos()->waitForElementNotVisible('#webpos_checkout > div.indicator');

        //PlaceOrder
        $this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
        $this->webposIndex->getMsWebpos()->waitForElementNotVisible('#webpos_checkout > div.indicator');
        sleep(1);
        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $this->webposIndex->getCheckoutPlaceOrder()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(1);

        //Get orderId
        $orderId = $this->webposIndex->getCheckoutSuccess()->getOrderId()->getText();
        $orderId = ltrim($orderId, '#');
        $this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
        sleep(1);
        $discount = floatval($webposRole->getMaximumDiscountPercent()) * ($product1->getPrice() + $product1->getPrice()) * 0.01;
        return [
            'orderId' => $orderId,
            'discount' => $discount,
            'shippingDescription' => 'Flat Rate - Fixed'
        ];
    }

    public function loginWebpos(WebposIndex $webposIndex, $username, $password)
    {
        $webposIndex->open();
        if ($webposIndex->getLoginForm()->isVisible()) {
            $webposIndex->getLoginForm()->getUsernameField()->setValue($username);
            $webposIndex->getLoginForm()->getPasswordField()->setValue($password);
            $webposIndex->getLoginForm()->clickLoginButton();
//			$this->webposIndex->getMsWebpos()->waitForSyncDataAfterLogin();
            sleep(2);
            $webposIndex->getMsWebpos()->waitForSyncDataVisible();
            $time = time();
            $timeAfter = $time + 360;
            while ($webposIndex->getFirstScreen()->isVisible() && $time < $timeAfter) {
                $time = time();
            }
            sleep(2);
        }
        $webposIndex->getCheckoutProductList()->waitProductListToLoad();
    }

}

