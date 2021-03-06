<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 3/7/2018
 * Time: 4:03 PM
 */

namespace Magento\Webpos\Test\TestCase\Staff\StaffPermission;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Fixture\WebposRole;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * *
 * Staff Permission
 * Testcase MS65 - Permission
 *
 * Precondition:
 * 1. Go to backend > Sales > Manage Roles
 * 2. Add a new role
 * - Permission: Manage All Orders
 * 3. Add new staff:
 * - Select the role that create on step 2
 * - Select location
 *
 * Steps
 * 1. Login webpos by the staff who created on step 3 of [Precondition and setup steps] column
 * 2. Check permission of this staff
 *
 * Acceptance Criteria
 * 1. Login webpos by the staff who created on step 3 of [Precondition and setup steps] column
 * 2. Check permission of this staff
 *
 * Class WebposManageStaffMS65Test
 * @package Magento\Webpos\Test\TestCase\Staff\StaffPermission
 */
class WebposManageStaffMS65Test extends Injectable
{

    /**
     * @var WebposIndex
     */
    private $webposIndex;

    /**
     * @var FixtureFactory
     */
    protected $fixtureFactory;

    /**
     * @param WebposIndex $webposIndex
     * @param FixtureFactory $fixtureFactory
     */
    public function __inject(
        WebposIndex $webposIndex,
        FixtureFactory $fixtureFactory
    )
    {
        $this->webposIndex = $webposIndex;
        $this->fixtureFactory = $fixtureFactory;
    }

    /**
     * @param FixtureFactory $fixtureFactory
     * @return array
     */
    public function __prepare(FixtureFactory $fixtureFactory)
    {
        //Config create session before working
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'create_section_before_working_yes_MS57']
        )->run();
        $staff = $fixtureFactory->createByCode('staff', ['dataset' => 'staff_ms61']);
        return ['staffData' => $staff->getData()];
    }

    /**
     * @param WebposRole $webposRole
     * @param $products
     * @param $staffData
     */
    public function test(WebposRole $webposRole, $products, $staffData)
    {
        //Create role and staff for role
        /**@var Location $location */
        $location = $this->fixtureFactory->createByCode('location', ['dataset' => 'default']);
        $location->persist();
        $locationId = $location->getLocationId();
        $posData['pos_name'] = 'Pos Test %isolation%';
        $posData['status'] = 'Enabled';
        $array = [];
        $array[] = $locationId;
        $posData['location_id'] = $array;
        /**@var Pos $pos */
        $pos = $this->fixtureFactory->createByCode('pos', ['data' => $posData]);
        $pos->persist();
        $posId = $pos->getPosId();
        $array = [];
        $array[] = $locationId;
        $staffData['location_id'] = $array;
        $array = [];
        $array[] = $posId;
        $staffData['pos_ids'] = $array;
        /**@var Staff $staff */
        $staff = $this->fixtureFactory->createByCode('staff', ['data' => $staffData]);
        $staff->persist();
        $roleData = $webposRole->getData();
        $array = [];
        $array[] = $staff->getStaffId();
        $roleData['staff_id'] = $array;
        $role = $this->fixtureFactory->createByCode('webposRole', ['data' => $roleData]);
        $role->persist();
        //Create product
        $products = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
            ['products' => $products]
        )->run();
        //LoginTest
        $this->login($staff, $location, $pos);
        $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="popup-open-shift"]');
        $this->webposIndex->getOpenSessionPopup()->getOpenSessionButton()->click();
        sleep(2);
        $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="c-button--push-left"]');
        $this->webposIndex->getMsWebpos()->getCMenuButton()->click();
        $this->assertFalse(
            $this->webposIndex->getCMenu()->manageStocksIsVisible(),
            'Manage Stocks on Menu is not hidden.'
        );
        $this->assertTrue(
            $this->webposIndex->getCMenu()->ordersMenuIsVisible(),
            'Order menu is not visible.'
        );
        $this->assertTrue(
            $this->webposIndex->getCMenu()->sessionManagementMenuIsVisible(),
            'Session Management menu is not visible.'
        );
        $this->assertTrue(
            $this->webposIndex->getCMenu()->customersMenuIsVisible(),
            'Customer menu is not visible.'
        );
        $this->assertTrue(
            $this->webposIndex->getCMenu()->settingsMenuIsVisible(),
            'Settings menu is not visible.'
        );
        $this->webposIndex->getCMenu()->checkout();
//        // Add product to cart
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\AddProductToCartStep',
            ['products' => $products]
        )->run();
        $this->assertFalse(
            $this->webposIndex->getCheckoutCartFooter()->getAddDiscount()->isVisible(),
            'Add discount function is not hidden.'
        );
        $this->webposIndex->getCheckoutCartItems()->getFirstCartItem()->click();
        $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="popup-edit-product"]');
        $this->assertFalse(
            $this->webposIndex->getCheckoutProductEdit()->getCustomPriceButton()->isVisible(),
            'Custom Price button is not hidden.'
        );
        $this->assertFalse(
            $this->webposIndex->getCheckoutProductEdit()->getDiscountButton()->isVisible(),
            'Discount button is not hidden.'
        );
        $this->webposIndex->getCheckoutProductEdit()->getClosePopupCustomerSale()->click();
        sleep(1);
        $this->webposIndex->getMsWebpos()->getCMenuButton()->click();
        $this->webposIndex->getCMenu()->ordersHistory();
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        $this->webposIndex->getMsWebpos()->waitOrdersHistoryVisible();
        $this->assertTrue(
            $this->webposIndex->getOrderHistoryOrderList()->getFirstOrder()->isVisible(),
            'Not show any order.'
        );

    }

    public function login(Staff $staff, Location $location = null, Pos $pos = null)
    {
        $username = $staff->getUsername();
        $password = $staff->getPassword();
        $this->webposIndex->open();
        $this->webposIndex->getMsWebpos()->waitForElementNotVisible('.loading-mask');
        if ($this->webposIndex->getLoginForm()->isVisible()) {
            $this->webposIndex->getLoginForm()->getUsernameField()->setValue($username);
            $this->webposIndex->getLoginForm()->getPasswordField()->setValue($password);
            $this->webposIndex->getLoginForm()->clickLoginButton();
            if ($location) {
                $this->webposIndex->getMsWebpos()->waitForElementNotVisible('.loading-mask');
                $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="webpos-location"]');
                $this->webposIndex->getLoginForm()->setLocation($location->getDisplayName());
            }
            if ($pos) {
                $this->webposIndex->getLoginForm()->setPos($pos->getPosName());
            }
            if ($location || $pos) {
                $this->webposIndex->getLoginForm()->getEnterToPos()->click();
            }
            $this->webposIndex->getMsWebpos()->waitForElementNotVisible('.loading-mask');
            $this->webposIndex->getMsWebpos()->waitForSyncDataVisible();
            $time = time();
            $timeAfter = $time + 360;
            while ($this->webposIndex->getFirstScreen()->isVisible() && $time < $timeAfter) {
                $time = time();
            }
            sleep(2);
        }
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
//        $this->webposIndex->getMsWebpos()->waitCartLoader();

    }

    public function tearDown()
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'create_section_before_working_no_MS57']
        )->run();
    }

}

