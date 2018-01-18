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
 * Class AssertTaxAmountAndShippingOnCartPageAndCheckoutPageWithShippingFee
 * @package Magento\Webpos\Test\Constraint\Tax
 */
class AssertTaxAmountAndShippingOnCartPageAndCheckoutPageWithShippingFee extends AbstractConstraint
{

    /**
     * @param $taxRate
     * @param $shippingFee
     * @param WebposIndex $webposIndex
     */
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

        $shippingFeeOnPage = $webposIndex->getCheckoutCartFooter()->getGrandTotalItemPrice("Shipping")->getText();
        $shippingFeeOnPage = (float)substr($shippingFeeOnPage,1);
        $shippingFeeOnCart = $shippingFee / (1 + $taxRate);
        $shippingFeeOnCart = round($shippingFeeOnCart, 2);


        $taxAmount = (float) ($subtotalOnPage - $discountOnPage) * $taxRate + ($shippingFee * ($taxRate / (1 + $taxRate)));
        $taxAmount = round($taxAmount, 2);
        $taxAmountOnPage = $webposIndex->getCheckoutCartFooter()->getGrandTotalItemPrice("Tax")->getText();
        $taxAmountOnPage = (float)substr($taxAmountOnPage,1);

        \PHPUnit_Framework_Assert::assertEquals(
            $taxAmount,
            $taxAmountOnPage,
            'On the Cart - The Tax at the web POS was not correctly.'
        );

        \PHPUnit_Framework_Assert::assertEquals(
            $shippingFeeOnCart,
            $shippingFeeOnPage,
            'On the Cart - The Shipping at the web POS was not correctly.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "The Tax and The Shipping at the web POS was correctly.";
    }
}