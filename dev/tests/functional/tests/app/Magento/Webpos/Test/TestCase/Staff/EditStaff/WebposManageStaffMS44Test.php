<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 12/02/2018
 * Time: 09:14
 */

namespace Magento\Webpos\Test\TestCase\Staff\EditStaff;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\StaffIndex;
use Magento\Webpos\Test\Page\Adminhtml\StaffNews;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Webpos\Test\Constraint\Staff\AssertCheckLocationForm;

/**
 * Edit staff
 * Testcase MS44 - Check filter function
 *
 * Precondition
 * Exist at least 2 location that doesnt link to any warehouse
 * 1. Go to backend > Sales > Manage Locations
 *
 * Steps
 * 1. Click on [Mapping Locations - Warehouses] button
 * 2. Click on [Choose Locations] button
 * 3. Click on Filter button
 * 4. Click on [Cancel] button
 *
 * Acceptance Criteria
 * 3. Show Filters form including:
 * - 4 fields: ID, Display name, Address, Description
 * - 2 buttons: Cancel, Apply filters
 * 4. Close Filters form
 *
 * Class WebposManageStaffMS44Test
 * @package Magento\Webpos\Test\TestCase\Staff\EditStaff
 */
class WebposManageStaffMS44Test extends Injectable
{
    /**
     * Webpos Staff Index page.
     *
     * @var StaffIndex
     */
    private $staffsIndex;
    /**
     * @var StaffNews
     */
    private $staffsNew;
    /**
     * @var WebposIndex
     */
    protected $webposIndex;
    /**
     * @var AssertCheckLocationForm
     */
    protected $assertCheckLocationForm;

    public function __prepare(FixtureFactory $fixtureFactory)
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'create_section_before_working_yes_MS57']
        )->run();
        $pos1 = $fixtureFactory->createByCode('pos', ['dataset' => 'MS44Staff']);
        $pos1->persist();
        $pos2 = $fixtureFactory->createByCode('pos', ['dataset' => 'MS44Staff']);
        $pos2->persist();
        return ['pos1' => $pos1,
            'pos2' => $pos2
        ];
    }

    public function __inject(
        StaffIndex $staffsIndex,
        StaffNews $staffsNew,
        WebposIndex $webposIndex,
        AssertCheckLocationForm $assertCheckLocationForm
    )
    {
        $this->staffsIndex = $staffsIndex;
        $this->staffsNew = $staffsNew;
        $this->webposIndex = $webposIndex;
        $this->assertCheckLocationForm = $assertCheckLocationForm;

    }

    public function test(Staff $staff, $pos1, $pos2)
    {
        // Preconditions:
        $location1 = $pos1->getDataFieldConfig('location_id')['source']->getLocation();
        $location2 = $pos2->getDataFieldConfig('location_id')['source']->getLocation();
        $staff->persist();
        // Steps
        $this->staffsIndex->open();
        $this->staffsIndex->getStaffsGrid()->search(['email' => $staff->getEmail()]);
        $this->staffsIndex->getStaffsGrid()->getRowByEmail($staff->getEmail())->find('.action-menu-item')->click();
        sleep(2);
        $this->staffsNew->getStaffsForm()->setPos([$pos1->getPosName(), $pos2->getPosName()]);
        $this->staffsNew->getStaffsForm()->setLocation([$location1->getDisplayName(), $location2->getDisplayName()]);
        $this->staffsNew->getFormPageActionsStaff()->save();

        //Open webpos
        $this->webposIndex->open();
        $this->webposIndex->getMsWebpos()->waitForElementNotVisible('.loading-mask');
        if ($this->webposIndex->getLoginForm()->isVisible()) {
            $this->webposIndex->getLoginForm()->getUsernameField()->setValue($staff->getUsername());
            $this->webposIndex->getLoginForm()->getPasswordField()->setValue($staff->getPassword());
            $this->webposIndex->getLoginForm()->clickLoginButton();
            $this->webposIndex->getMsWebpos()->waitForElementNotVisible('.loading-mask');
            $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="webpos-location"]');
            $locations = [
                [
                    'location' => $location1,
                    'pos' => $pos1,
                ],
                [
                    'location' => $location2,
                    'pos' => $pos2,
                ]
            ];
            $this->assertCheckLocationForm->processAssert($this->webposIndex, $locations);
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

