<?php
/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 3/1/2018
 * Time: 1:15 PM
 */

namespace Magento\Webpos\Test\Constraint\Sync;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertSynchronizationPageErrorLog extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSyncErrorLogs()->getButtonAll()->isVisible(),
            'Synchronization - Synchronization page is not shown'
        );
    }

    public function toString()
    {
        return "Synchronization Page is display correctly";
    }
}