<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 27/11/2017
 * Time: 16:43
 */

namespace Magento\PurchaseOrderSuccess\Test\Constraint\Form;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\PurchaseOrderSuccess\Test\Page\Adminhtml\PricelistIndex;

class AssertImportPricelistFormIsAvailable extends AbstractConstraint
{
	public function processAssert(PricelistIndex $pricelistIndex, $pageTitle)
	{
		sleep(2);
		\PHPUnit_Framework_Assert::assertEquals(
			$pageTitle,
			$pricelistIndex->getModalImportPricelist()->getTitle(),
			'Import Pricelist Modal - Title is wrong'
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$pricelistIndex->getModalImportPricelist()->getCancelButton()->isVisible(),
			'Import Pricelist Modal - Cancel button is not shown'
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$pricelistIndex->getModalImportPricelist()->getImportButton()->isVisible(),
			'Import Pricelist Modal - Import button is not shown'
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$pricelistIndex->getModalImportPricelist()->getChooseFileButton()->isVisible(),
			'Import Pricelist Modal - Choose file to import button is not shown'
		);

	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Import Pricelist Modal - Add Pricelist form is available";
	}
}