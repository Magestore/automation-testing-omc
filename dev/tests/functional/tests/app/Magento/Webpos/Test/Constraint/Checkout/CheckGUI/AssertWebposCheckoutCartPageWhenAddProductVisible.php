<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 04/12/2017
 * Time: 11:44
 */

namespace Magento\Webpos\Test\Constraint\Checkout\CheckGUI;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class AssertWebposCheckoutCartPageWhenAddProductVisible
 * @package Magento\AssertWebposCheckGUICustomerPriceCP54\Test\Constraint\Checkout\CheckGUI
 */
class AssertWebposCheckoutCartPageWhenAddProductVisible extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $labels, $defaultValue)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutCartItems()->getProductImage()->isVisible(),
            'On the Frontend Page - The PRODUCT THUMBNAIL IMAGE at the web POS Cart was not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutCartItems()->getProductPrice()->isVisible(),
            'On the Frontend Page - The PRODUCT PRICE at the web POS Cart was not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutCartItems()->getIconDeleteItem()->isVisible(),
            'On the Frontend Page - The icon DELETE CART ITEM at the web POS Cart was not visible.'
        );
        $labels = explode(',', $labels);
        foreach ($labels as $label) {
            \PHPUnit_Framework_Assert::assertNotEquals(
                $defaultValue,
                str_replace('$', '', $webposIndex->getCheckoutCartFooter()->getGrandTotalItemPrice($label)->getText()),
                'On the Frontend Page - The New ' .$label. ' at the AssertWebposCheckGUICustomerPriceCP54 Cart was not updated.'
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
        return "On the Frontend Page - All the Button, Icon at the web POS Cart were visible and the value was uodated  successfully.";
    }
}