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
 * Class WebposSync02Test
 * @package Magento\Webpos\Test\TestCase\Sync\CheckGUI
 * Precondition and setup steps
 * 1. Login Webpos as a staff
 *
 * Steps
 * 1. Click on [Synchronization] menu
 * 2. Click on [Error Logs] tab
 *
 * Acceptance Criteria
 * 2. Display Error logs page including:
 * - Button: All
 * - Table of Error message with columns: ID, Error message, Action
 */
class WebposSync02Test extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

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
        $this->webposIndex->getSyncTabRight()->tabErrorLogs()->click();
        sleep(1);
    }
}