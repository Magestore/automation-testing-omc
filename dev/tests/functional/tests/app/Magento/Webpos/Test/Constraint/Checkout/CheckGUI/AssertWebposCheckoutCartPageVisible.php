<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 04/12/2017
 * Time: 11:06
 */

namespace Magento\Webpos\Test\Constraint\Checkout\CheckGUI;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class AssertWebposCheckoutCartPageVisible
 * @package Magento\Webpos\Test\Constraint\Checkout\CheckGUI
 */
class AssertWebposCheckoutCartPageVisible extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $labels, $defaultValue)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutCartHeader()->getIconDeleteCart()->isVisible(),
            'On the Frontend Page - The Icon DELETE CART at the web POS Cart was not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutCartHeader()->getIconAddCustomer()->isVisible(),
            'On the Frontend Page - The Icon ADD CUSTOMER at the web POS Cart was not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutCartHeader()->getIconActionMenu()->isVisible(),
            'On the Frontend Page - The Icon ACTION MENU at the web POS Cart was not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutCartHeader()->getAddMultiOrder()->isVisible(),
            'On the Frontend Page - The Icon MULTI ORDER at the web POS Cart was not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutCartFooter()->getButtonHold()->isVisible(),
            'On the Frontend Page - The button HOLD at the web POS Cart was not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutCartFooter()->getButtonCheckout()->isVisible(),
            'On the Frontend Page - The button CHECKOUT at the web POS Cart was not visible.'
        );
        $labels = explode(',', $labels);
        foreach ($labels as $label) {
            \PHPUnit_Framework_Assert::assertEquals(
                $defaultValue,
                str_replace('$', '', $webposIndex->getCheckoutCartFooter()->getGrandTotalItemPrice($label)->getText()),
                'On the Frontend Page - The Default ' .$label. ' at the Webpos Cart was not equal to zero.'
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
        return "On the Frontend Page - All the Button And Icon at the web POS Cart were visible successfully.";
    }
}