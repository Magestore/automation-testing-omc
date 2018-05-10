<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 11/12/2017
 * Time: 14:11
 */

namespace Magento\Webpos\Test\TestStep;

use Magento\Mtf\TestStep\TestStepInterface;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\Adminhtml\StaffIndex;
use Magento\Webpos\Test\Page\Adminhtml\StaffEdit;
/**
 * Class DeleteStaffEntityStep
 * @package Magento\Webpos\Test\TestStep
 */
class DeleteStaffEntityStep implements TestStepInterface
{
    /* tags */
    const MVP = 'yes';
    const DOMAIN = 'CS';
    /* end tags */
    /**
     * Webpos Staff Index page.
     *
     * @var StaffIndex
     */
    private $staffsIndex;
    /**
     * @var StaffEdit
     */
    protected $staffEdit;
    /**
     * Webpos Index page.
     *
     * @var Staff
     */
    protected $staff;

    /**
     *
     * @param StaffIndex $staffsIndex
     * @param StaffEdit $staffEdit
     */
    public function __construct(
        StaffIndex $staffsIndex,
        StaffEdit $staffEdit,
        Staff $staff
    ) {
        $this->staffsIndex = $staffsIndex;
        $this->staffEdit = $staffEdit;
        $this->staff = $staff;
    }


    public function run()
    {
        // Preconditions:
        // staff send from TestCase not persist
//        $this->staff->persist();

        // Steps:
        $filter = ['email' => $this->staff->getEmail()];
        $this->staffsIndex->open();
        $this->staffsIndex->getStaffsGrid()->searchAndOpen($filter);
        $this->staffEdit->getFormPageActions()->delete();
        $this->staffEdit->getModalBlock()->acceptAlert();
    }
}
