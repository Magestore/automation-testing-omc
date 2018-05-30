<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 25/05/2018
 * Time: 15:29
 */

namespace Magento\Webpos\Test\TestCase\SessionManagement\ForceSignOut;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\StaffEdit;
use Magento\Webpos\Test\Page\Adminhtml\StaffIndex;

/**
 * Class AdminSessionManagementFS01Test
 * @package Magento\Webpos\Test\TestCase\SessionManagement\ForceSignOut
 *
 * Precondition:
 * - Manage staff permission is assigned to magento users
 *
 * Steps:
 * 1. Login backend with user assigned to Manage staff permission
 * 2. Go to Manage staff page (path:Sales -> Webpos -> Manage staff)
 * 3. From Manage staff page, select a staff that is not loged in yet webpos
 * 4. Observe the staff detail page
 *
 * Acceptance:
 * 4. Hide the Force sign out button in staff detail page
 *
 */
class AdminSessionManagementFS01Test extends Injectable
{
    /**
     * @var StaffIndex $staffIndex
     */
    protected $staffIndex;

    /**
     * @var StaffEdit $staffEdit
     */
    protected $staffEdit;

    public function __inject(
        StaffIndex $staffIndex,
        StaffEdit $staffEdit
    )
    {
        $this->staffIndex = $staffIndex;
        $this->staffEdit = $staffEdit;
    }

    public function test(
        FixtureFactory $fixtureFactory
    )
    {
        $staff = $fixtureFactory->createByCode('staff', ['dataset' => 'default']);
        $staff->persist();

        $this->staffIndex->open();
        $this->staffIndex->getStaffsGrid()->searchAndOpen(
            [
                'username' => $staff->getUsername()
            ]
        );
        $this->assertFalse(
            $this->staffEdit->getFormPageActions()->getForceSignOutButton()->isVisible(),
            'Button Force signout not hidden'
        );
    }
}