<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 3/9/2018
 * Time: 9:24 AM
 */

namespace Magento\Webpos\Test\TestCase\Staff\StaffPermission;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Fixture\WebposRole;
use Magento\Webpos\Test\Page\WebposIndex;
use function MongoDB\BSON\toJSON;

/**
 * *
 * Staff Permission
 * Testcase MS79 - Permission
 *
 * Precondition:
 * Exist an opening shift on webpos
 * 1. Go to backend > Sales > Manage Roles
 * 2. Add a new role with permission:
 * + Can Make Shift Adjustment
 * 3. Add new staff:
 * - Select the role that create on step 2
 * - Select location
 * 4. Go to settings webpos:
 * [Need to create session before working] = Yes
 *
 * Steps
 * 1. Login webpos by the staff who created on step 3 of [Precondition and setup steps] column
 * 2. Click on [Session management] menu
 *
 * Acceptance Criteria
 * 2.
 * - Hide [Manage stocks] on menu
 * - Hide discount function, can't edit custom price and add discount  for whole cart
 * - Show [Orders] [Session management], [Customers] and [Settings] menu
 * 3. Place order successfully
 *
 * Class WebposManageStaffMS79Test
 * @package Magento\Webpos\Test\TestCase\Staff\StaffPermission
 */
class WebposManageStaffMS79Test extends Injectable
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
     * Inject WebposIndex pages.
     *
     * @param $webposIndex
     * @return void
     */
    public function __inject(
        WebposIndex $webposIndex,
        FixtureFactory $fixtureFactory
    )
    {
        $this->webposIndex = $webposIndex;
        $this->fixtureFactory = $fixtureFactory;
    }

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
     * Create WebposRole group test.
     *
     * @param WebposRole
     * @return void
     */
    public function test(WebposRole $webposRole, $staffData)
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
        //LoginTest
        $this->login($staff, $location, $pos);
        $this->webposIndex->getMsWebpos()->getCMenuButton()->click();
        $this->webposIndex->getCMenu()->getSessionManagement();
        sleep(1);
        $this->assertFalse(
            $this->webposIndex->getSessionShift()->getOpenShiftButton()->isVisible(),
            'Open shift icon is not hidden.'
        );
        $this->assertFalse(
            $this->webposIndex->getListShift()->getFirstItemShift()->isVisible(),
            'Open a shift not successfully.'
        );
        $this->assertTrue(
            $this->webposIndex->getSessionInfo()->getPutMoneyInButton()->isVisible(),
            'Put Money In is not visible.'
        );
        $this->assertTrue(
            $this->webposIndex->getSessionInfo()->getTakeMoneyOutButton()->isVisible(),
            'Take Money Out is not visible.'
        );
        $this->assertFalse(
            $this->webposIndex->getSessionInfo()->getSetClosingBalanceButton()->isVisible(),
            'Set Closing Balance is not hidden.'
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

