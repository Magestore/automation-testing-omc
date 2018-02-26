<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 22/02/2018
 * Time: 15:14
 */

namespace Magento\Webpos\Test\Constraint\Setting\General;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class AssertWebPOSCheckGUIGeneralPageDisplayCorrectly
 * @package Magento\Webpos\Test\Constraint\Setting\General
 */
class AssertWebPOSCheckGUIGeneralPageDisplayCorrectly extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     */
    public function processAssert(WebposIndex $webposIndex, $menuItems)
    {
        $menuItems = explode(',', $menuItems);
        foreach ($menuItems as $menuItem) {
            \PHPUnit_Framework_Assert::assertTrue(
                $webposIndex->getGeneralSettingMenuLMainItem()->getMenuItem($menuItem)->isVisible(),
                'On the Setting General Page - The '.$menuItem.' Menu is not visible.'
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
        return 'On the Setting General Page. All Menu Item were visible correctly.';
    }
}