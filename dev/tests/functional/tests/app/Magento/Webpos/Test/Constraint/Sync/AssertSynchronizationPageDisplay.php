<?php

/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 2/26/2018
 * Time: 8:34 AM
 */
namespace Magento\Webpos\Test\Constraint\Sync;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class AssertSynchronizationPageDisplay
 * @package Magento\Webpos\Test\Constraint\Sync
 */
class AssertSynchronizationPageDisplay extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex)
    {
        $webposIndex->getSyncTabData()->waitUpdateAllButton();
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSyncTabData()->getUpdateAllButton()->isVisible(),
            'Synchronization - Update All Button is not shown'
        );
        $webposIndex->getSyncTabData()->waitReloadAllButton();
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSyncTabData()->getReloadAllButton()->isVisible(),
            'Synchronization - Reload All Button is not shown'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Synchronization Page is display correctly";
    }
}