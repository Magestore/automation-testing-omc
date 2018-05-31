<?php

/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 2/23/2018
 * Time: 3:57 PM
 */

namespace Magento\Webpos\Test\TestCase\Sync\CheckGUI;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposSync03Test
 * @package Magento\Webpos\Test\TestCase\Sync\CheckGUI
 * Precondition and setup steps
 * 1. Login Webpos as a staff
 *
 * Steps
 * 1. Click on [Synchronization] menu
 * 2. Click on [Reset local database] button
 *
 * Acceptance Criteria
 * 2. Screen back to Sync page to sync whole database
 */
class WebposSync03Test extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * @param WebposIndex $webposIndex
     */
    public function __inject(
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
    }

    /**
     * @param FixtureFactory $fixtureFactory
     */
    public function test(FixtureFactory $fixtureFactory)
    {
        $staff = $this->objectManager->create(
            '\Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->synchronization();

        sleep(2);
        $this->webposIndex->getSyncTabRight()->buttonResetLocal()->click();
    }
}