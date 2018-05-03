<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/2/18
 * Time: 4:45 PM
 */

namespace Magento\Webpos\Test\Constraint\SessionManagement\CheckAssignmentPermission;

use Magento\Webpos\Test\Page\Adminhtml\PosIndex;
use Magento\Webpos\Test\Page\Adminhtml\PosEdit;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Class AssertPosCheckLockUnlockLR18
 * @package Magento\Webpos\Test\Constraint\SessionManagement\CheckAssignmentPermission
 */
class AssertPosCheckLockUnlockLR18 extends AbstractConstraint
{
    /**
     * @param PosIndex $posIndex
     * PosEdit $posEdit
     */
    public function processAssert(PosIndex $posIndex, PosEdit $posEdit, $pos_name, $is_allow_to_lock, $pin)
    {
        $posIndex->open();
        $posIndex->getPosGrid()->resetFilter();
        $posIndex->getPosGrid()->searchAndOpen(['pos_name' => $pos_name]);
        $posEdit->getPosForm()->getIsAllowToLockField()->setValue($is_allow_to_lock);
        $posEdit->getPosForm()->getSecurityPinField()->setValue($pin);
        $posEdit->getFormPageActions()->saveAndContinue();
        \PHPUnit_Framework_Assert::assertEquals(
            'Pos was successfully saved',
            $posIndex->getMessagesBlock()->getSuccessMessage(),
            'Success message is wrong.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $posEdit->getFormPageActions()->getLockButton()->isVisible(),
            'Lock Button is not visible.'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $posEdit->getFormPageActions()->getLockButton()->getText(),
            'Lock',
            'Lock Button is not visible.'
        );
    }

    /**
     * Returns a string representation of the object
     *
     * @return string
     */
    public function toString()
    {
        return 'Check when user assigned permission to lock register successfully.';
    }
}