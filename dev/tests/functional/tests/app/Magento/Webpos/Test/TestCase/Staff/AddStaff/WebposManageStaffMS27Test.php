<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 17/02/2018
 * Time: 19:27
 */
namespace Magento\Webpos\Test\TestCase\Staff\AddStaff;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\StaffIndex;
use Magento\Webpos\Test\Page\Adminhtml\StaffNews;

class WebposManageStaffMS27Test extends Injectable
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
    ) {
        $this->staffsIndex = $staffsIndex;
        $this->staffsNew = $staffsNew;
    }
    public function test()
    {
        // Steps
        $this->staffsIndex->open();
        $this->staffsIndex->getPageActionsBlock()->addNew();
        sleep(1);
        $this->staffsNew->getFormPageActionsStaff()->saveAndContinue();
        sleep(1);
    }
}

