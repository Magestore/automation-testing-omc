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
use Magento\Webpos\Test\Constraint\Staff\AssertShowHideMenu;
use Magento\Webpos\Test\Constraint\Staff\AssertShowHideDiscountFunction;
use Magento\Webpos\Test\Constraint\Staff\AssertEditCustomPrice;

/**
 *
 * *
 * Staff Permission
 * Testcase MS58 - Permission
 *
 * Precondition:
 * 1. Go to backend > Sales > Manage Roles
 * 2. Add a new role:
 * - Permission: Manage Order Created By This Staff
 * - Select a staff A
 *
 * Steps
 * 1. Login webpos by staff A
 * 2. Go to [Order history] menu
 *
 * Acceptance Criteria
 * 1.
 * - Hide [Manage stocks] on menu
 * - Hide discount function, can't edit custom price and add discount  for whole cart
 * - Show [Orders] [Session management], [Customers] and [Settings] menu
 * 2. On [Order history] page, only show the order that created by staff A
 *
 * Class WebposManageStaffMS58Test
 * @package Magento\Webpos\Test\TestCase\Staff\StaffPermission
 */
class WebposManageStaffMS58Test extends Injectable
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

    )
    {
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
    public function test(WebposRole $webposRole, FixtureFactory $fixtureFactory, $products)
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
        sleep(3);
        //Check show hide item menu
        $this->assertShowHideMenu->processAssert($this->webposIndex, [
            ['id' => 'item_manage_stock',
                'tag' => false],
            ['id' => 'group_customer',
                'tag' => true],
            ['id' => 'group_setting',
                'tag' => true]
        ]);

    }

    public function loginWebpos(WebposIndex $webposIndex, $username, $password, $locationName, $roleName)
    {
        $webposIndex->open();
        if ($webposIndex->getLoginForm()->isVisible()) {
            $webposIndex->getLoginForm()->getUsernameField()->setValue($username);
            $webposIndex->getLoginForm()->getPasswordField()->setValue($password);
            $webposIndex->getLoginForm()->clickLoginButton();
            $webposIndex->getMsWebpos()->waitForElementNotVisible('#checkout-loader');
            $webposIndex->getMsWebpos()->waitForElementVisible('[id="webpos-location"]');
            $webposIndex->getLoginForm()->setLocation($locationName);
            $webposIndex->getLoginForm()->setPos($roleName);
            $webposIndex->getLoginForm()->getEnterToPos()->click();
            $webposIndex->getMsWebpos()->waitForSyncDataVisible();
            $time = time();
            $timeAfter = $time + 360;
            while ($webposIndex->getFirstScreen()->isVisible() && $time < $timeAfter) {
                $time = time();
            }
            sleep(2);
        }
        $webposIndex->getCheckoutProductList()->waitProductListToLoad();
        if ($this->webposIndex->getOpenSessionPopup()->isOpenSessionDisplay()) {
            $this->webposIndex->getOpenSessionPopup()->getOpenSessionButton()->click();
            $this->webposIndex->getMsWebpos()->clickCMenuButton();
            $this->webposIndex->getCMenu()->checkout();
        }
        sleep(2);
        $this->webposIndex->getOpenSessionPopup()->getCancelButton()->click();
    }

    public function tearDown()
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'create_section_before_working_no_MS57']
        )->run();
    }
}

