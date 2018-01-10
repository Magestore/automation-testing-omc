<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 05/01/2018
 * Time: 16:17
 */

namespace Magento\Webpos\Test\Constraint\Tax;


use Magento\Mtf\Constraint\AbstractAssertForm;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertTaxOnOrderDetailIsCorrect extends AbstractAssertForm
{
	public function processAssert(WebposIndex $webposIndex, $products, $taxRate)
	{
		$taxRate = (float) $taxRate/100;
		$wholeTax = 0;
		$wholeSubTotal = 0;
        $discountAmountWholeCart = 0;
        foreach ($products as $item) {
			$productName = $item['product']->getName();
			$subTotal = (float) substr($webposIndex->getOrderHistoryOrderViewContent()->getSubTotalOfProduct($productName),1);
			$taxAmount = (float) substr($webposIndex->getOrderHistoryOrderViewContent()->getTaxAmountOfProduct($productName),1);
			$discountAmount = (float) substr($webposIndex->getOrderHistoryOrderViewContent()->getDiscountAmountOfProduct($productName),1);
            $rowTotal = (float) substr($webposIndex->getOrderHistoryOrderViewContent()->getRowTotalOfProduct($productName),1);

			\PHPUnit_Framework_Assert::assertEquals(
				($subTotal - $discountAmount) * $taxRate,
				$taxAmount,
				"Tax amount of product '".$productName."' is wrong"
			);
			\PHPUnit_Framework_Assert::assertEquals(
				$subTotal + $taxAmount - $discountAmount,
				$rowTotal,
				"Row Total of product '".$productName."' is wrong"
			);
			$wholeTax += $taxAmount;
			$wholeSubTotal += $subTotal;
            $discountAmountWholeCart += $discountAmount;

        }

		$subTotal = (float) substr($webposIndex->getOrderHistoryOrderViewFooter()->getSubtotal(),1);
		$shipping = (float) substr($webposIndex->getOrderHistoryOrderViewFooter()->getShipping(),1);
		$tax = 0;
		$discount = 0;
		$grandTotal = (float) substr($webposIndex->getOrderHistoryOrderViewFooter()->getGrandTotal(),1);
		if($wholeTax != 0){
		    $tax = (float) substr($webposIndex->getOrderHistoryOrderViewFooter()->getTax(),1);
            \PHPUnit_Framework_Assert::assertEquals(
                $wholeTax,
                $tax,
                "Whole Tax is wrong"
            );
        }
        if($discountAmountWholeCart != 0){
            $discount = (float) substr($webposIndex->getOrderHistoryOrderViewFooter()->getDiscount(),2);
        }

		\PHPUnit_Framework_Assert::assertEquals(
			$wholeSubTotal,
			$subTotal,
			"Whole SubTotal is wrong"
		);

		\PHPUnit_Framework_Assert::assertEquals(
			$subTotal + $shipping + $tax - $discount,
			$grandTotal,
			"Grand Total is wrong"
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Order History Page - Tax on ProductTable is correct";
	}
}