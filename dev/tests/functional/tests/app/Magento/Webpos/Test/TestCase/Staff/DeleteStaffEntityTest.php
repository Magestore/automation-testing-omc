<?php

/**
 * @Author: Thomas Mr 0
 * @Created At:   2017-09-07 15:38:41
 * @Email:  thomas@trueplus.vn
 * @Last Modified by:   thomas
 * @Last Modified time: 2017-10-11 13:35:13
 * @Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\TestCase\Staff;

use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\Adminhtml\StaffIndex;
use Magento\Webpos\Test\Page\Adminhtml\StaffEdit;
use Magento\Mtf\TestCase\Injectable;

/**
 * Preconditions:
 * 1. Create AssertWebposCheckGUICustomerPriceCP54 Staff.
 * Steps:
 * 1. Login to backend.
 * 2. Open Sales -> AssertWebposCheckGUICustomerPriceCP54 -> Manage Staff.
 * 3. Open Staff from preconditions.
 * 4. Delete.
 * 5. Perform all asserts.
 * @group Staff(PS)
 * @ZephyrId MAGETWO-28459
 */
class DeleteStaffEntityTest extends Injectable
{
    /* tags */
    const MVP = 'yes';
    const DOMAIN = 'CS';
    /* end tags */

    /**
     * @var StaffIndex
     */
    protected $staffIndexPage;

    /**
     * @var StaffEdit
     */
    protected $staffEditPage;

    /**
     * Preparing pages for test
     *
     * @param StaffIndex $staffIndexPage
     * @param StaffEdit $staffEditPage
     * @return void
     */
    public function __inject(
        StaffIndex $staffIndexPage,
        StaffEdit $staffEditPage
    )
    {
        $this->staffIndexPage = $staffIndexPage;
        $this->staffEditPage = $staffEditPage;
    }

    /**
     * @param Staff $staff
     * @throws \Exception
     */
    public function testDeleteStaffEntityTest(Staff $staff)
    {
        // Preconditions:
        $staff->persist();

        // Steps:
        $filter = ['email' => $staff->getEmail()];
        $this->staffIndexPage->open();
        $this->staffIndexPage->getStaffsGrid()->searchAndOpen($filter);
        $this->staffEditPage->getFormPageActions()->delete();
        $this->staffEditPage->getModalBlock()->acceptAlert();
    }
}

