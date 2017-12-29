<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 05/12/2017
 * Time: 17:14
 */

namespace Magento\Webpos\Test\Constraint\Checkout\CartPageActionMenu;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class AssertWebposCheckoutAddOrderNote
 * @package Magento\Webpos\Test\Constraint\CategoryRepository\CartPageActionMenu
 */
class AssertWebposCheckoutAddOrderNote extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutNoteOrder()->getCloseOrderNoteButton()->isVisible(),
            'On the Products List Page - The action CLOSE ORDER NOTE on the popup add order note of the web POS TaxClass was not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutNoteOrder()->getSaveOrderNoteButon()->isVisible(),
            'On the Products List Page - The action SAVE ORDER NOTE on the popup add order note of the web POS TaxClass was not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutNoteOrder()->getTextArea()->isVisible(),
            'On the Products List Page - The TEXT AREA on the popup add order note of the web POS TaxClass was not visible.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "On the CategoryRepository Page - Products List Page - All the action CLOSE ORDER NOTE And SAVE ORDER NOTE, TEXTAREA at the web POS TaxClass were visible successfully.";
    }
}