<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 12/02/2018
 * Time: 09:14
 */
namespace Magento\Webpos\Test\TestCase\Staff\EditStaff;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\Adminhtml\StaffIndex;
use Magento\Webpos\Test\Page\Adminhtml\StaffNews;
use Magento\Webpos\Test\Constraint\Adminhtml\Staff\Form\AssertPopupDelete;
class WebposManageStaffMS47Test extends Injectable
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
     * @var AssertPopupDelete
     */
    private $assertPopupDelete;
    /**
     * Inject Staff pages.
     *
     * @param StaffIndex $staffsIndex
     * @return void
     */
    public function __inject(
        StaffIndex $staffsIndex,
        StaffNews $staffsNew,
        AssertPopupDelete $assertPopupDelete
    ) {
        $this->staffsIndex = $staffsIndex;
        $this->staffsNew = $staffsNew;
        $this->assertPopupDelete = $assertPopupDelete;
    }

    public function test(Staff $staff)
    {
        // Preconditions:
        $staff->persist();

        // Steps
        $this->staffsIndex->open();
        $this->staffsIndex->getStaffsGrid()->search(['email' => $staff->getEmail()]);
        $this->staffsIndex->getStaffsGrid()->getRowByEmail($staff->getEmail())->find('.action-menu-item')->click();
        sleep(1);
        $this->staffsNew->getFormPageActionsStaff()->deleteButton()->click();

        //Check open popup when click delete
        $message = 'Are you sure you want to do this?';
        $this->assertPopupDelete->processAssert($this->staffsNew,
            ['tag' =>'open', 'message' => $message]);

        //Cancel
        $this->staffsNew->getModalsWrapper()->getCancelButton()->click();
        sleep(1);

        return [
            'info' => ['tag' =>'close',
                'message' => $message
                ]
        ];
    }
}

