<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 24/05/2018
 * Time: 09:02
 */

namespace Magento\Webpos\Test\Constraint\Setting\General;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertWebPOSCheckGUILockRegister
 * @package Magento\Webpos\Test\Constraint\Setting\General
 */
class AssertWebPOSCheckGUILockRegister extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     */
    public function processAssert(WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getGeneralSettingContentRight()->getLabelSecurityPIN()->isVisible(),
            'label security pin not visible'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getGeneralSettingContentRight()->getPOSAccountPassword()->isVisible(),
            'pos account password not visible'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getGeneralSettingContentRight()->getSecurityPIN()->isVisible(),
            'security pin not visible'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getGeneralSettingContentRight()->getLockRegisterButtonSave()->isVisible(),
            'Button save not visible'
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