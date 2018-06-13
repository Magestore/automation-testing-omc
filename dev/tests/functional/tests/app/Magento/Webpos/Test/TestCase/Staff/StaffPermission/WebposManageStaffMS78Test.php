<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 3/9/2018
 * Time: 8:23 AM
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
 * Testcase MS78 - Permission
 *
 * Precondition:
 * 1. Go to backend > Sales > Manage Roles
 * 2. Add a new role with permission:
 * + Manage Shift (select all sub-menus)
 * 3. Add new staff:
 * - Select the role that create on step 2
 * - Select location
 * 4. Go to settings webpos:
 * [Need to create session before working] = Yes
 *
 * Steps
 * 1. Login webpos by the staff who created on step 3 of [Precondition and setup steps] column
 * 2. Open a shift
 * 3. Input money in
 * 4. Take money out
 * 5. Close the shift
 *
 * Acceptance Criteria
 * 2. Open a shift successfully
 * 3. Input money in successfully
 * 4. Take money out successfully
 * 5. Close the shift successfully
 *
 * Class WebposManageStaffMS78Test
 * @package Magento\Webpos\Test\TestCase\Staff\StaffPermission
 */
class WebposManageStaffMS78Test extends Injectable
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
        $staffData['location_id'] = [$locationId];
        $staffData['pos_ids'] = [$posId];
        /**@var Staff $staff */
        $staff = $this->fixtureFactory->createByCode('staff', ['data' => $staffData]);
        $staff->persist();
        $roleData = $webposRole->getData();
        $roleData['staff_id'] = [$staff->getStaffId()];
        $role = $this->fixtureFactory->createByCode('webposRole', ['data' => $roleData]);
        $role->persist();
        //LoginTest
        $this->login($staff, $location, $pos);
        $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="popup-open-shift"]');
        $this->webposIndex->getOpenSessionPopup()->getOpenSessionButton()->click();
        $this->webposIndex->getMsWebpos()->waitForElementNotVisible('[id="popup-open-shift"]');
        sleep(5);
        $this->assertTrue(
            $this->webposIndex->getListShift()->getFirstItemShift()->isVisible(),
            'Open a shift not successfully.'
        );

        //Put money in
        $this->webposIndex->getSessionInfo()->getPutMoneyInButton()->click();
        $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="popup-make-adjustment"]');
        $this->webposIndex->getPutMoneyInPopup()->getAmountInput()->setValue(69);
        $this->webposIndex->getPutMoneyInPopup()->getDoneButton()->click();
        $this->webposIndex->getMsWebpos()->waitForElementNotVisible('[id="popup-make-adjustment"]');
        sleep(3);
        //Take money out
        $this->webposIndex->getSessionInfo()->getTakeMoneyOutButton()->click();
        $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="popup-make-adjustment"]');
        $this->webposIndex->getPutMoneyInPopup()->getAmountInput()->setValue(69);
        $this->webposIndex->getPutMoneyInPopup()->getDoneButton()->click();
        sleep(2);
        $this->webposIndex->getMsWebpos()->waitForElementNotVisible('[id="popup-make-adjustment"]');
        //Close the shift
        sleep(2);
        $this->webposIndex->getSessionInfo()->getSetClosingBalanceButton()->click();
        $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="popup-close-shift"]');
        $this->webposIndex->getSessionCloseShift()->getConfirmSession()->click();
        $this->webposIndex->getMsWebpos()->waitForElementNotVisible('[id="popup-close-shift"]');
        $this->webposIndex->getSessionShift()->getButtonEndSession()->click();
        $this->webposIndex->getSessionShift()->waitForElementNotVisible('.btn-close-shift');

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

