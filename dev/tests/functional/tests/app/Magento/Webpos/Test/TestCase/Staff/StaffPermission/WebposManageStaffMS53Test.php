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
use Magento\Webpos\Test\Constraint\Adminhtml\Staff\Permission\AssertWarningDiscountCustomPrice;
use Magento\Webpos\Test\Constraint\Adminhtml\Staff\Permission\AssertEditDiscountCustomPrice;
/**
 * Class WebposManageStaffMS53Test
 * @package Magento\Webpos\Test\TestCase\Staff\StaffPermission
 */
class WebposManageStaffMS53Test extends Injectable
{

    /**
     * @var WebposIndex
     */
    private $webposIndex;

    /**
     * @var AssertWarningDiscountCustomPrice
     */
    protected $assertWarningDiscountCustomPrice;

    /**
     * @var AssertEditDiscountCustomPrice
     */
    protected $assertEditDiscountCustomPrice;

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
        WebposIndex $webposIndex,
        AssertWarningDiscountCustomPrice $assertWarningDiscountCustomPrice,
        AssertEditDiscountCustomPrice $assertEditDiscountCustomPrice
    ) {
        $this->webposIndex = $webposIndex;
        $this->assertWarningDiscountCustomPrice = $assertWarningDiscountCustomPrice;
        $this->assertEditDiscountCustomPrice = $assertEditDiscountCustomPrice;
    }

    /**
     * Create WebposRole group test.
     *
     * @param WebposRole
     * @return void
     */
    public function test(WebposRole $webposRole, $products, $priceCustom)
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
        $this->loginWebpos($this->webposIndex, $dataStaff['username'],$dataStaff['password']);

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
        $this->webposIndex->getCheckoutCartItems()->getFirstCartItem()->click();
        $this->webposIndex->getCheckoutProductEdit()->getDiscountButton()->click();
        $this->webposIndex->getCheckoutProductEdit()->getPercentButton()->click();
        $this->webposIndex->getCheckoutProductEdit()->getAmountInput()->setValue($priceCustom);
        $this->webposIndex->getCheckoutProductEdit()->getClosePopupCustomerSale()->click();
        sleep(1);
        $this->assertWarningDiscountCustomPrice->processAssert($this->webposIndex, 'You are able to apply discount under '.$webposRole->getMaximumDiscountPercent().'% only');
        $this->webposIndex->getCheckoutCartFooter()->waitForElementVisible('.checkout');
        sleep(1);
        $this->assertEditDiscountCustomPrice->processAssert($this->webposIndex, $webposRole->getMaximumDiscountPercent(), 1);

        //Cart
        $this->webposIndex->getCheckoutCartFooter()->waitForElementVisible('.checkout');
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $this->webposIndex->getMsWebpos()->waitForElementNotVisible('#webpos_checkout > div.indicator');

        //PlaceOrder
        $this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
        sleep(1);
        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $this->webposIndex->getCheckoutPlaceOrder()->waitCartLoader();
        sleep(1);

        //Get orderId
        $orderId = $this->webposIndex->getCheckoutSuccess()->getOrderId()->getText();
        $orderId= ltrim ($orderId,'#');
        $this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
        sleep(1);
        return [
            'orderId' => $orderId,
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
            sleep(2);
//			$this->webposIndex->getMsWebpos()->waitForSyncDataAfterLogin();
            $webposIndex->getMsWebpos()->waitForSyncDataVisible();
            $time = time();
            $timeAfter = $time + 360;
            while ($webposIndex->getFirstScreen()->isVisible() && $time < $timeAfter){
                $time = time();
            }
            sleep(2);
        }
        $webposIndex->getCheckoutProductList()->waitProductListToLoad();
    }

}

