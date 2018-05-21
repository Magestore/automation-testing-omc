<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 1/12/2018
 * Time: 10:57 AM
 */

namespace Magento\Webpos\Test\Constraint\Tax;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertTaxAmountOnCartPageAndCheckoutPageWithShippingFee
 * @package Magento\Webpos\Test\Constraint\Tax
 */
class AssertTaxAmountOnCartPageAndCheckoutPageWithShippingFee extends AbstractConstraint
{

    public function processAssert($taxRate, $shippingFee, WebposIndex $webposIndex)
    {
        $taxRate = (float) $taxRate / 100;
        $subtotalOnPage = $webposIndex->getCheckoutCartFooter()->getGrandTotalItemPrice("Subtotal")->getText();
        $subtotalOnPage = (float)substr($subtotalOnPage,1);
        if($webposIndex->getCheckoutCartFooter()->getGrandTotalItemPrice("Discount")->isVisible()){
            $discountOnPage = $webposIndex->getCheckoutCartFooter()->getGrandTotalItemPrice("Discount")->getText();
            $discountOnPage = (float)substr($discountOnPage,2);
        }else{
            $discountOnPage = 0;
        }

        $taxAmount = (float) ($subtotalOnPage - $discountOnPage) * $taxRate + ($shippingFee * ($taxRate / (1 + $taxRate)));
        $taxAmount = round($taxAmount, 2);
        $taxAmountOnPage = $webposIndex->getCheckoutCartFooter()->getGrandTotalItemPrice("Tax")->getText();
        $taxAmountOnPage = (float)substr($taxAmountOnPage,1);

        \PHPUnit_Framework_Assert::assertEquals(
            $taxAmount,
            $taxAmountOnPage,
            'On the Checkout - The Tax at the web POS was not correctly.'
        );

    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "The Tax at the web POS was correctly.";
    }
}