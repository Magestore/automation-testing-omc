<?php
/**
 * Created by: thomas
 * Date: 03/11/2017
 * Time: 14:27
 * Email:  thomas@trueplus.vn
 * Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\Constraint\Synchronization\Configuration;

use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Magento\Webpos\Test\Constraint\Synchronization\Configuration
 * AssertSynchronizationConfigColorSuccess
 */
class AssertSynchronizationConfigColorSuccess extends AbstractConstraint
{
    public function processAssert($result)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            'Configuration Synchroniration was updated success',
            $result['success-message'],
            'We can not update'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Synchronization - Item Update/Reload Success";
    }
}