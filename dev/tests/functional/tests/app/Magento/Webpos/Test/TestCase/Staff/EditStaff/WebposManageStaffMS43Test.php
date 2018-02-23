<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 12/02/2018
 * Time: 09:14
 */
namespace Magento\Webpos\Test\TestCase\Staff\EditStaffOnGrid;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\StaffIndex;
use Magento\Webpos\Test\Page\Adminhtml\StaffNews;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposManageStaffMS43Test extends Injectable
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
    public function __inject(
        StaffIndex $staffsIndex,
        StaffNews $staffsNew,
        WebposIndex $webposIndex
    ) {
        $this->staffsIndex = $staffsIndex;
        $this->staffsNew = $staffsNew;
        $this->webposIndex = $webposIndex;

    }

    public function test(FixtureFactory $fixtureFactory)
    {
        // Preconditions:
        $staff = $fixtureFactory->createByCode('staff', ['dataset' => 'staffMS21']);
        $staff->persist();
        // Steps
        $this->staffsIndex->open();
        $this->staffsIndex->getStaffsGrid()->search(['email' => $staff->getEmail()]);
        $this->staffsIndex->getStaffsGrid()->getRowByEmail($staff->getEmail())->find('.action-menu-item')->click();
        sleep(1);
        $this->staffsNew->getStaffsForm()->setPassword('gmail1234');
        $this->staffsNew->getStaffsForm()->setConfimPassword('gmail1234');
        $this->staffsNew->getFormPageActionsStaff()->save();
        sleep(1);

        return ['userName' => $staff->getUsername(),
            'passOld' => $staff->getPassword(),
            'passNew' => 'gmail1234'
        ];
    }
}

