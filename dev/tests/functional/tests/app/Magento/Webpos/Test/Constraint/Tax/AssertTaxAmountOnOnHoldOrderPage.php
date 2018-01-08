<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 1/5/2018
 * Time: 4:47 PM
 */

namespace Magento\Webpos\Test\Constraint\Tax;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertTaxAmountOnCartPageAndCheckoutPage
 * @package Magento\Webpos\Test\Constraint\Tax
 */
class AssertTaxAmountOnOnHoldOrderPage extends AbstractConstraint
{

    /**
     * @param $taxRate
     * @param $products
     * @param WebposIndex $webposIndex
     */
    public function processAssert($taxRate, $products, WebposIndex $webposIndex)
    {
        $taxRate = (float) $taxRate / 100;

        foreach ($products as $item) {
            $subtotal = $webposIndex->getOnHoldOrderOrderViewContent()->getSubtotalOfProduct($item['product']->getName())->getText();
            $subtotal = (float)substr($subtotal,1);
            $taxAmount = $subtotal * $taxRate;
            $taxAmountOnPage = $webposIndex->getOnHoldOrderOrderViewContent()->getTaxAmountOfProduct($item['product']->getName())->getText();
            $taxAmountOnPage = (float)substr($taxAmountOnPage,1);

            \PHPUnit_Framework_Assert::assertEquals(
                $taxAmount,
                $taxAmountOnPage,
                'On the On-Hold Orders - The Tax Amount was not correctly at product'.$item['product']->getName()
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
        return "The Tax Amount on On-Hold Orders was correctly.";
    }
}