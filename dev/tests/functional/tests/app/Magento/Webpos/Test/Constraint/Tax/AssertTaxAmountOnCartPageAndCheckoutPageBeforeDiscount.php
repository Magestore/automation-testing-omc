<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 1/17/2018
 * Time: 9:16 AM
 */

namespace Magento\Webpos\Test\Constraint\Tax;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertTaxAmountOnCartPageAndCheckoutPageBeforeDiscount extends AbstractConstraint
{

    public function processAssert($taxRate, WebposIndex $webposIndex, $addShipFee = false)
    {
        $taxRate = (float) $taxRate / 100;
        $subtotalOnPage = $webposIndex->getCheckoutCartFooter()->getGrandTotalItemPrice("Subtotal")->getText();
        $subtotalOnPage = (float)substr($subtotalOnPage,1);

        $shippingFee = 0;
        if ($addShipFee) {
            $shippingFee = $webposIndex->getCheckoutCartFooter()->getGrandTotalItemPrice('Shipping')->getText();
            $shippingFee = (float)substr($shippingFee, 1);
        }

        $taxAmount = ($subtotalOnPage + $shippingFee) * $taxRate;
        $taxAmount = round($taxAmount, 2);
        $taxAmountOnPage = $webposIndex->getCheckoutCartFooter()->getGrandTotalItemPrice("Tax")->getText();
        $taxAmountOnPage = (float)substr($taxAmountOnPage,1);

        \PHPUnit_Framework_Assert::assertEquals(
            $taxAmount,
            $taxAmountOnPage,
            'On the Cart - The Tax at the web POS was not correctly.'
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