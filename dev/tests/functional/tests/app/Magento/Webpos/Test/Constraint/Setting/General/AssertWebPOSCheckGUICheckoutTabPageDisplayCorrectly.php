<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 22/02/2018
 * Time: 15:47
 */

namespace Magento\Webpos\Test\Constraint\Setting\General;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class AssertWebPOSCheckGUICheckoutTabPageDisplayCorrectly
 * @package Magento\Webpos\Test\Constraint\Setting\General
 */
class AssertWebPOSCheckGUICheckoutTabPageDisplayCorrectly extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     */
    public function processAssert(WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getGeneralSettingContentRight()->getUseOnlineModeSelection()->isVisible(),
            'On the Setting General Page - In the menu Checkout Page. Use Online Mode Selection were visible correctly.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getGeneralSettingContentRight()->getAutoCheckPromotionSelection()->isVisible(),
            'On the Setting General Page - In the menu Checkout Page. Use Auto Check Promotion Selection were visible correctly.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getGeneralSettingContentRight()->getSyncOnHoldOrderToServerSelection()->isVisible(),
            'On the Setting General Page - In the menu Checkout Page. Use Sync On Hold Order To Server Selection were visible correctly.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'On the Setting General Page. In the menu Checkout Page. Everything were visible correctly.';
    }
}