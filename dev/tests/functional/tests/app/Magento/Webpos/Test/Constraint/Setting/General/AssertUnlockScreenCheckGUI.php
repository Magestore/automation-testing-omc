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

/**
 * Class AssertUnlockScreenCheckGUI
 * @package Magento\Webpos\Test\Constraint\Setting\General
 */
class AssertUnlockScreenCheckGUI extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     */
    public function processAssert(WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getLockScreen()->getLockIcon()->isVisible(),
            'Lock icon not visible'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getLockScreen()->getLockText()->isVisible(),
            'Lock text not visible'
        );
        for ($i = 1; $i < 5; $i++) {
            \PHPUnit_Framework_Assert::assertTrue(
                $webposIndex->getLockScreen()->getInputUnLockRegisterPin($i)->isVisible(),
                'Lock Screen input lock register pin ' . $i . ' not visible'
            );
        }
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'On the Lock Screen. In the menu Lock Register. Everything were visible correctly.';
    }
}