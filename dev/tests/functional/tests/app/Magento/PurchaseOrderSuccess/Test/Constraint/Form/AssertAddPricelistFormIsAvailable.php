<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 27/11/2017
 * Time: 16:04
 */

namespace Magento\PurchaseOrderSuccess\Test\Constraint\Form;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\PurchaseOrderSuccess\Test\Page\Adminhtml\PricelistIndex;

class AssertAddPricelistFormIsAvailable extends AbstractConstraint
{
	public function processAssert(PricelistIndex $pricelistIndex, $pageTitle)
	{
		sleep(1);
		\PHPUnit_Framework_Assert::assertEquals(
			$pageTitle,
			$pricelistIndex->getModalAddPricelist()->getTitle(),
			'Add Pricelist Modal - Title is wrong'
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$pricelistIndex->getModalAddPricelist()->getCancelButton()->isVisible(),
			'Add Pricelist Modal - Cancel button is not shown'
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$pricelistIndex->getModalAddPricelist()->getAddSelectedProductsButton()->isVisible(),
			'Add Pricelist Modal - Add selected product(s) button is not shown'
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$pricelistIndex->getModalAddPricelist()->getSupplierSelect()->isVisible(),
			'Add Pricelist Modal - Supplier select field is not shown'
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$pricelistIndex->getModalAddPricelist()->getSelectProductButton()->isVisible(),
			'Add Pricelist Modal - Select Product Button is not shown'
		);

	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Add Pricelist Modal - Add Pricelist form is available";
	}
}