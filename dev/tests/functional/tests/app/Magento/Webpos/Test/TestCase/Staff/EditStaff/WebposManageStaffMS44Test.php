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
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Page\WebposIndex;

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
     * Inject Staff pages.
     *
     * @param StaffIndex $staffsIndex
     * @return void
     */
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    public function __prepare(Location $location, Pos $pos)
    {
        $location->persist();
        $pos->persist();
        return ['location' => $location,
            'pos' => $pos];
    }

    public function __inject(
        StaffIndex $staffsIndex,
        StaffNews $staffsNew,
        WebposIndex $webposIndex
    ) {
        $this->staffsIndex = $staffsIndex;
        $this->staffsNew = $staffsNew;
        $this->webposIndex = $webposIndex;

    }

    public function test(Staff $staff, Location $location, Pos $pos)
    {
        // Preconditions:
        $location->persist();
        $pos->persist();
        $staff->persist();
        // Steps
        $this->staffsIndex->open();
        $this->staffsIndex->getStaffsGrid()->search(['email' => $staff->getEmail()]);
        $this->staffsIndex->getStaffsGrid()->getRowByEmail($staff->getEmail())->find('.action-menu-item')->click();
        sleep(1);
        $this->staffsNew->getStaffsForm()->setLocation($location->getDisplayName());
        $this->staffsNew->getStaffsForm()->setPos($pos->getPosName());
        sleep(1);
        $this->staffsNew->getFormPageActionsStaff()->save();
        $this->webposIndex->open();
        $this->webposIndex->getLoginForm()->getUsernameField()->setValue($staff->getUsername());
        $this->webposIndex->getLoginForm()->getPasswordField()->setValue($staff->getPassword());
        $this->webposIndex->getLoginForm()->clickLoginButton();
//			$this->webposIndex->getMsWebpos()->waitForSyncDataAfterLogin();
        $this->webposIndex->getMsWebpos()->waitForSyncDataVisible();
        $time = time();
        $timeAfter = $time + 360;
        while ($this->webposIndex->getFirstScreen()->isVisible() && $time < $timeAfter){
            $time = time();
        }
        sleep(2);
    }
}

