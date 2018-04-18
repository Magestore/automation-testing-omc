<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 22/02/2018
 * Time: 16:02
 */

namespace Magento\Webpos\Test\Constraint\Setting\General;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class AssertWebPOSCheckGUIPOSHubTabPageDisplayCorrectly
 * @package Magento\Webpos\Test\Constraint\Setting\General
 */
class AssertWebPOSCheckGUIPOSHubTabPageDisplayCorrectly extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     */
    public function processAssert(WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getGeneralSettingContentRight()->getServerIPAddress()->isVisible(),
            'On the Setting General Page - In the menu Currency Tab Page. Server IP Address was visible correctly.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getGeneralSettingContentRight()->getEnableOpenCashSelection()->isVisible(),
            'On the Setting General Page - In the menu Currency Tab Page. Enable Open Cash Selection was visible correctly.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getGeneralSettingContentRight()->getCashDrawerKickInput()->isVisible(),
            'On the Setting General Page - In the menu Currency Tab Page. Cash Drawer Kick Input was visible correctly.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getGeneralSettingContentRight()->getPrintViaPOSHubSelection()->isVisible(),
            'On the Setting General Page - In the menu Currency Tab Page. Print Via POS Hub Selection was visible correctly.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getGeneralSettingContentRight()->getEnablePoleDisplaySelection()->isVisible(),
            'On the Setting General Page - In the menu Currency Tab Page. Enable Pole Display Selection was visible correctly.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'On the Setting General Page. In the menu POS Hub Page. Everything were visible correctly.';
    }
}