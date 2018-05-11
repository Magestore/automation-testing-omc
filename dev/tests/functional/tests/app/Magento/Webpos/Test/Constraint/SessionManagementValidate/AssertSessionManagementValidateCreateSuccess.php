<?php

/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 3/15/2018
 * Time: 9:40 AM
 */
namespace Magento\Webpos\Test\Constraint\SessionManagementValidate;

use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Class AssertSetReasonPopup
 * @package Magento\Webpos\Test\Constraint\SessionManagement
 */
class AssertSessionManagementValidateCreateSuccess extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     */
    public function processAssert(WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSessionShift()->getBtnOpen()->isVisible(),
            'Session not create'
        );
    }

    /**
     * Returns a string representation of the object
     *
     * @return string
     */
    public function toString()
    {
        return 'Set Reason Popup is correct.';
    }
}