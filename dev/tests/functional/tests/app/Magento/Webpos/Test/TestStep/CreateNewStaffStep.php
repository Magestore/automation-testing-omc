<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 11/12/2017
 * Time: 14:07
 */

namespace Magento\Webpos\Test\TestStep;

use Magento\Mtf\TestStep\TestStepInterface;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\Adminhtml\StaffIndex;
use Magento\Webpos\Test\Page\Adminhtml\StaffNews;
/**
 * Class CreateNewStaffStep
 * @package Magento\Webpos\Test\TestStep
 */
class CreateNewStaffStep implements TestStepInterface
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
     * Webpos Index page.
     *
     * @var Staff
     */
    protected $staff;

    /**
     *
     * @param StaffIndex $staffsIndex
     * @param StaffNews $staffsNew
     */
    public function __construct(
        StaffIndex $staffsIndex,
        StaffNews $staffsNew,
        Staff $staff
    ) {
        $this->staffsIndex = $staffsIndex;
        $this->staffsNew = $staffsNew;
        $this->staff = $staff;
    }

    public function run()
    {
        // Steps
        $this->staffsIndex->open();
        $this->staffsIndex->getPageActionsBlock()->addNew();
        $this->staffsNew->getStaffsForm()->fill($this->staff);
        $this->staffsNew->getFormPageActions()->save();
    }
}
