<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 05/12/2017
 * Time: 16:20
 */

namespace Magento\Webpos\Test\Constraint\Checkout\CartPageActionMenu;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class AssertWebposCheckActionMenuTopRightScreen
 * @package Magento\Webpos\Test\Constraint\Checkout\CartPageActionMenu
 */
class AssertWebposCheckActionMenuTopRightScreen extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex)
    {
        $webposIndex->getCheckoutCartHeader()->getIconActionMenu()->click();
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutFormAddNote()->getAddOrderNote()->isVisible(),
            'On the Products List Page - The action ADD ORDER NOTE on the top right of the web POS Cart was not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutFormAddNote()->getFullScreenMode()->isVisible(),
            'On the Products List Page - The action FULL SCREEN MODE on the top right of the web POS Cart was not visible.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "On the Checkout Page - Products List Page - All the action ADD ORDER NOTE And FULL SCREEN MODE at the web POS Cart were visible successfully.";
    }
}