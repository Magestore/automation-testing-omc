<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 25/05/2018
 * Time: 13:38
 */

namespace Magento\Webpos\Test\Constraint\Adminhtml\SystemConfig;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\SystemConfigEditSectionWebpos;

/**
 * Class AssertWebposConfigCheckGUI
 * @package Magento\Webpos\Test\Constraint\Adminhtml\SystemConfig
 */
class AssertWebposConfigCheckGUI extends AbstractConstraint
{
    public function processAssert(SystemConfigEditSectionWebpos $systemConfigEditSectionWebpos)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $systemConfigEditSectionWebpos->getForm()->getPOSAccountSharingLabel()->isVisible(),
            'Label POS Account sharing not visible'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $systemConfigEditSectionWebpos->getForm()->getPOSAccountSharingDropdown()->isVisible(),
            'Dropdown POS Account sharing not visible'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $systemConfigEditSectionWebpos->getForm()->getPOSAccountSharingTextGuide()->isVisible(),
            'Text guide POS Account sharing not visible'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Webpos Config - GUI correct';
    }
}