<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 17/02/2018
 * Time: 19:27
 */

namespace Magento\Webpos\Test\TestCase\Staff\CheckValidation;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\Adminhtml\StaffIndex;
use Magento\Webpos\Test\Page\Adminhtml\StaffNews;

/**
 * Check validation
 * Testcase MS35 - Check [Cancel] button
 *
 * Precondition
 * 1. Go to backend > Sales > Manage Staffs
 *
 * Steps
 * 1. Click on [Mapping Locations - Warehouses] button
 * 2. Click [Cancel] button on [Mapping Locations - Warehouse] page
 *
 * Acceptance Criteria
 * 2. Back to Location page
 *
 * Class WebposManageStaffMS35Test
 * @package Magento\Webpos\Test\TestCase\Staff\CheckValidation
 *
 */
class WebposManageStaffMS35Test extends Injectable
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
     * Inject Staff pages.
     *
     * @param StaffIndex $staffsIndex
     * @return void
     */

    public function __inject(
        StaffIndex $staffsIndex,
        StaffNews $staffsNew
    )
    {
        $this->staffsIndex = $staffsIndex;
        $this->staffsNew = $staffsNew;
    }

    /**
     * @param Staff $staff
     * @param FixtureFactory $fixtureFactory
     * @return array
     */
    public function test(Staff $staff, FixtureFactory $fixtureFactory)
    {
        //Create staff
        $staff1 = $fixtureFactory->createByCode('staff', ['dataset' => 'staffMS21']);
        $staff1->persist();
        // Steps
        $this->staffsIndex->open();
        $this->staffsIndex->getPageActionsBlock()->addNew();
        sleep(1);
        $this->staffsNew->getStaffsForm()->fill($staff);
        $this->staffsNew->getStaffsForm()->setEmailAddress($staff1->getEmail());
        $this->staffsNew->getFormPageActions()->save();
        sleep(1);

        return ['message' => 'Email ' . $staff1->getEmail() . ' is existed.'];
    }
}

