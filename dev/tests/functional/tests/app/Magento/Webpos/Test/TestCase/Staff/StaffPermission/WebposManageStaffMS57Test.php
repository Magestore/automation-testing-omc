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
use Magento\Webpos\Test\Constraint\Staff\AssertShowHideMenu;
use Magento\Webpos\Test\Constraint\Staff\AssertShowHideDiscountFunction;
use Magento\Webpos\Test\Constraint\Staff\AssertEditCustomPrice;
class WebposManageStaffMS57Test extends Injectable
{

    /**
     * @var WebposIndex
     */
    private $webposIndex;

    /**
     * @var AssertShowHideMenu
     */
    protected $assertShowHideMenu;

    /**
     * @var AssertShowHideDiscountFunction
     */
    protected $assertShowHideDiscountFunction;

    /**
     * @var AssertEditCustomPrice
     */
    protected $assertEditCustomPrice;

    public function __prepare()
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'have_shipping_method_on_webpos_CP197']
        )->run();
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'create_section_before_working_yes_MS57']
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
        AssertShowHideMenu $assertShowHideMenu,
        AssertShowHideDiscountFunction $assertShowHideDiscountFunction,
        AssertEditCustomPrice $assertEditCustomPrice

    ) {
        $this->webposIndex = $webposIndex;
        $this->assertShowHideMenu = $assertShowHideMenu;
        $this->assertShowHideDiscountFunction = $assertShowHideDiscountFunction;
        $this->assertEditCustomPrice = $assertEditCustomPrice;
    }

    /**
     * Create WebposRole group test.
     *
     * @param WebposRole
     * @return void
     */
    public function test(WebposRole $webposRole, $products)
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

        //Login
        $this->loginWebpos($this->webposIndex, $dataStaff['username'],$dataStaff['password']);

        //Check show hide item menu
        $this->assertShowHideMenu->processAssert($this->webposIndex,[
            ['id' => 'item_manage_stock',
                'tag' => false],
            ['id' => 'group_customer',
                'tag' => true],
            ['id' => 'group_setting',
                'tag' => true]
        ]);

        //Add products to cart
        $this->webposIndex->getCheckoutProductList()->search($product1->getName());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        sleep(1);
        $this->webposIndex->getCheckoutProductList()->search($product2->getName());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        sleep(1);

        //Check can't edit custom price
        $this->assertEditCustomPrice->processAssert($this->webposIndex, [1,2]);

        //Check hide dicount function
        $this->assertShowHideDiscountFunction->processAssert($this->webposIndex, 'hide');

        //Checkout
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();

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
            $webposIndex->getMsWebpos()->waitForElementNotVisible('#checkout-loader');
            $webposIndex->getMsWebpos()->waitForElementVisible('[id="webpos-location"]');
            $webposIndex->getLoginForm()->setLocation('Store Address');
            $webposIndex->getLoginForm()->setPos('Store POS');
            $webposIndex->getLoginForm()->getEnterToPos()->click();
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
        if($this->webposIndex->getOpenSessionPopup()->isOpenSessionDisplay())
        {
            $this->webposIndex->getOpenSessionPopup()->getOpenSessionButton()->click();
            $this->webposIndex->getMsWebpos()->clickCMenuButton();
            $this->webposIndex->getCMenu()->checkout();
        }
    }
    public function tearDown()
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'create_section_before_working_no_MS57']
        )->run();
    }
}

