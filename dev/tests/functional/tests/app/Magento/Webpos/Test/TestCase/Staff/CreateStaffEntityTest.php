<?php

/**
 * @Author: Thomas Mr 0
 * @Created At:   2017-09-07 14:20:50
 * @Email:  thomas@trueplus.vn
 * @Last Modified by:   thomas
 * @Last Modified time: 2017-10-06 11:31:01
 * @Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\TestCase\Staff;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\Adminhtml\StaffIndex;
use Magento\Webpos\Test\Page\Adminhtml\StaffNews;

/**
 * Steps:
 * 1. Log in to Admin.
 * 2. Open the Sales -> Staff Manage page.
 * 3. Click the "New Staff" button.
 * 4. Enter data according to a data set. For each variation, the Staff must have unique identifiers.
 * 5. Click the "Save Staff Group" button.
 * 6. Verify the Staff group saved successfully.
 */
class CreateStaffEntityTest extends Injectable
{
    /**
     * Webpos Staff Index page.
     *
     * @var StaffIndex
     */
    private $staffsIndex;

    /**
     * New Staff Group page.
     *
     * @var StaffNews
     */
    private $staffsNew;


    /**
     * Inject Staff pages.
     *
     * @param StaffIndex $staffsIndex
     * @param StaffNews $staffsNew
     * @param FixtureFactory $fixtureFactory
     * @return void
     */
    public function __inject(
        StaffIndex $staffsIndex,
        StaffNews $staffsNew
    ) {
        $this->staffsIndex = $staffsIndex;
        $this->staffsNew = $staffsNew;
    }

    /**
     * @param Staff $staff
     */
    public function test(Staff $staff)
    {
        $this->staffsIndex->open();
        $this->staffsIndex->getPageActionsBlock()->addNew();
        $this->staffsNew->getStaffsForm()->fill($staff);
        $this->staffsNew->getFormPageActions()->save();
    }

}

