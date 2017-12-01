<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/29/2017
 * Time: 8:47 AM
 */

namespace Magento\Customercredit\Test\Constraint\Settings;

use Magento\Customercredit\Test\Page\Adminhtml\SystemConfig;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertSettingsPageAvailable extends AbstractConstraint
{

    public function processAssert(SystemConfig $systemConfig, $configItem, $sectionNames)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $systemConfig->getSystemConfigTabs()->getConfigItem($configItem)->isVisible(),
            'System config ' . $configItem .' is not visible.'
        );
        $sectionNamesArray = explode(",", $sectionNames);
        foreach ($sectionNamesArray as $sectionName) {
            \PHPUnit_Framework_Assert::assertTrue(
                $systemConfig->getSystemConfigForm()->getSectionConfigByName($sectionName)->isVisible(),
                'Section config ' . $sectionName . ' is not visible.'
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
        return 'Settings page is available.';
    }
}