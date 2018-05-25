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
 * Class AssertWebposConfigCheckDefaultPOSAccountSharing
 * @package Magento\Webpos\Test\Constraint\Adminhtml\SystemConfig
 */
class AssertWebposConfigCheckDefaultPOSAccountSharing extends AbstractConstraint
{
    public function processAssert(SystemConfigEditSectionWebpos $systemConfigEditSectionWebpos)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            'No',
            $systemConfigEditSectionWebpos->getForm()->getPOSAccountSharingDropdown()->getValue(),
            'Label POS Account sharing not visible'
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