<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 25/01/2018
 * Time: 13:57
 */
namespace Magento\Webpos\Test\Constraint\OnHoldOrder\HoldOrder;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertCheckTaxOnHoldOrder extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $tax, $products)
    {
        sleep(1);

        //Check tax in table
        $taxActualInTable = str_replace('$','',$webposIndex->getOnHoldOrderOrderViewFooter()->getRowValue('Tax'));
        \PHPUnit_Framework_Assert::assertEquals(
            floatval($tax[0]),
            floatval($taxActualInTable),
            'Tax is not correct, taxExpected is : $'.$tax[0].' and taxActual in table is : $'.$taxActualInTable
        );

        //Check tax item
        for ($i=0; $i<count($products); ++$i)
        {
            $taxActualInItem = str_replace('$','',$webposIndex->getOnHoldOrderOrderViewContent()->getTaxAmountProductByOrderTo($i+1));
            \PHPUnit_Framework_Assert::assertEquals(
                floatval($tax[$i+1]),
                floatval($taxActualInItem),
                'Tax is not correct, taxExpected is : $'.$tax[$i].' and taxActual in table is : $'.$taxActualInItem
            );
        }

        $webposIndex->getMsWebpos()->clickCMenuButton();
        $webposIndex->getCMenu()->checkout();
        sleep(1);
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Tax is correct";
    }
}