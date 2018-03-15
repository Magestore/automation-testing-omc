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

    public function __prepare(FixtureFactory $fixtureFactory)
    {
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
        WebposIndex $webposIndex
    ) {
        $this->staffsIndex = $staffsIndex;
        $this->staffsNew = $staffsNew;
        $this->webposIndex = $webposIndex;

    }

    public function test(Staff $staff, Pos $pos1, Pos $pos2)
    {
        // Preconditions:
        $location1 = $pos1->getDataFieldConfig('location_id')['source']->getLocation();
        $location2 = $pos2->getDataFieldConfig('location_id')['source']->getLocation();

        $staff->persist();
        // Steps
        $this->staffsIndex->open();
        $this->staffsIndex->getStaffsGrid()->search(['email' => $staff->getEmail()]);
        $this->staffsIndex->getStaffsGrid()->getRowByEmail($staff->getEmail())->find('.action-menu-item')->click();
        sleep(1);
        $this->staffsNew->getStaffsForm()->setPos([$pos1->getPosName(), $pos2->getPosName()]);
        $this->staffsNew->getStaffsForm()->setLocation([$location1->getDisplayName(), $location2->getDisplayName()]);
        sleep(1);
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
            $this->webposIndex->getLoginForm()->setLocation($location1->getDisplayName());
            $this->webposIndex->getLoginForm()->getEnterToPos()->click();
            $this->webposIndex->getLoginForm()->setPos($pos1->getPosName());
            $this->webposIndex->getMsWebpos()->waitForElementNotVisible('.loading-mask');
//            $this->webposIndex->getLoginForm()->getEnterToPos()->click();

        }

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

