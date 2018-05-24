<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 24/05/2018
 * Time: 09:34
 */

namespace Magento\Webpos\Test\Constraint\Setting\General;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertLockRegisterCheckFormMessage extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     */
    public function processAssert(WebposIndex $webposIndex, $message)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            $message,
            $webposIndex->getToaster()->getWarningMessage()->getText(),
            'Message save Lock Register not correct'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'On the Setting General Page. In the menu Lock Register. Everything were visible correctly.';
    }
}