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
 * Class WebposSync01Test
 * @package Magento\Webpos\Test\TestCase\Sync\CheckGUI
 * Precondition and setup steps
 * 1. Login Webpos as a staff
 *
 * Steps
 * 1. Click on [Synchronization] menu
 *
 * Acceptance Criteria
 * 1. Display Synchronization page including:
 * - On the left page, show 2 tabs: [Sync Data], [Error Logs] and [Reset local database] button
 * - On the right page, show sync list with [Last updated] time and [Update], [Reload] actions
 */
class WebposSync01Test extends Injectable
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
    }
}