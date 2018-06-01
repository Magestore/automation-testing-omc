<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 12/02/2018
 * Time: 09:14
 */

namespace Magento\Webpos\Test\TestCase\Staff\StaffPermission;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\WebposRole;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Webpos\Test\Constraint\Adminhtml\Staff\Permission\AssertEditDiscountCustomPrice;

/**
 * Staff Permission
 * Testcase MS55 - Edit custom price and discount for whole cart
 *
 * Precondition:
 * 1. Go to backend > Sales > Manage Roles
 * 2. Add a new role:
 * - Maximum discount percent(%): 0
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
 * Class WebposManageStaffMS55Test
 * @package Magento\Webpos\Test\TestCase\Staff\StaffPermission
 */
class WebposManageStaffMS55Test extends Injectable
{

    /**
     * @var WebposIndex
     */
    private $webposIndex;

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
        AssertEditDiscountCustomPrice $assertEditDiscountCustomPrice
    )
    {
        $this->webposIndex = $webposIndex;
        $this->assertEditDiscountCustomPrice = $assertEditDiscountCustomPrice;
    }

    /**
     * Create WebposRole group test.
     *
     * @param WebposRole
     * @return void
     */
    public function test(WebposRole $webposRole, FixtureFactory $fixtureFactory, $products, $priceCustom, $discount)
    {
        /*Create pos and location*/
        $pos = $fixtureFactory->createByCode('pos', ['dataset' => 'MS57Staff']);
        $pos->persist();
        $dataLocation = $pos->getDataFieldConfig('location_id')['source']->getLocation()->getData();
        $webposRole->persist();
        $staff = $fixtureFactory->createByCode('staff', ['dataset' => 'staffMS21']);
        $dataStaff = $staff->getData();
        $dataStaff['location_id'] = [$dataLocation['location_id']];
        $dataStaff['pos_ids'] = [$pos->getData('pos_id')];
        $dataStaff['role_id'] = $webposRole->getRoleId();
        $staff = $fixtureFactory->createByCode('staff', ['data' => $dataStaff]);
        $staff->persist();
        //LoginTest
        $this->loginWebpos($this->webposIndex, $dataStaff['username'], $dataStaff['password'], $dataLocation['display_name'], $pos->getData('pos_name'));
        sleep(2);
        $this->webposIndex->getOpenSessionPopup()->getOpenSessionButton()->click();
        $this->webposIndex->getSessionShift()->getButtonEndSession()->click();
        sleep(1);
        $this->webposIndex->getSessionSetClosingBalancePopup()->getConfirmButton()->click();
        sleep(1);
        $this->webposIndex->getMsWebpos()->getCMenuButton()->click();
        $this->webposIndex->getCMenu()->waitForElementVisible('#checkout');
        $this->webposIndex->getCMenu()->checkout();

        //Create product
        $products = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
            ['products' => $products]
        )->run();
        $product1 = $products[0]['product'];
        $product2 = $products[1]['product'];

        //Add products to cart
        $this->webposIndex->getCheckoutProductList()->search($product1->getName());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        sleep(1);
        $this->webposIndex->getCheckoutProductList()->search($product2->getName());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        sleep(2);
    }

    public function loginWebpos(WebposIndex $webposIndex, $username, $password, $locationName, $posName)
    {
        $webposIndex->open();
        if ($webposIndex->getLoginForm()->isVisible()) {
            $webposIndex->getLoginForm()->getUsernameField()->setValue($username);
            $webposIndex->getLoginForm()->getPasswordField()->setValue($password);
            $webposIndex->getLoginForm()->clickLoginButton();
            $webposIndex->getMsWebpos()->waitForElementNotVisible('#checkout-loader');
            $webposIndex->getMsWebpos()->waitForElementVisible('[id="webpos-location"]');
            $webposIndex->getLoginForm()->setLocation($locationName);
            $webposIndex->getLoginForm()->setPos($posName);
            $webposIndex->getLoginForm()->getEnterToPos()->click();
            //			$this->webposIndex->getMsWebpos()->waitForSyncDataAfterLogin();
            $webposIndex->getMsWebpos()->waitForSyncDataVisible();
            $time = time();
            $timeAfter = $time + 360;
            while ($webposIndex->getFirstScreen()->isVisible() && $time < $timeAfter) {
                $time = time();
            }
            sleep(5);
        }
//        $webposIndex->getCheckoutProductList()->waitProductListToLoad();
        if ($this->webposIndex->getOpenSessionPopup()->isOpenSessionDisplay()) {
            $this->webposIndex->getOpenSessionPopup()->getOpenSessionButton()->click();
            $this->webposIndex->getMsWebpos()->clickCMenuButton();
            $this->webposIndex->getCMenu()->checkout();
        }
    }

}

