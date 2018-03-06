<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 06/03/2018
 * Time: 11:19
 */

namespace Magento\Webpos\Test\Constraint\ManageStocks\UpdateProductAttributes;


use Magento\Catalog\Test\Page\Adminhtml\CatalogProductEdit;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertProductIsUpdatedInBackend extends AbstractConstraint
{
	public function processAssert(CatalogProductEdit $catalogProductEdit, $productInfo)
	{
		$catalogProductEdit->open(['id' => $productInfo['product']->getId()]);
		$formData = $catalogProductEdit->getProductForm()->getData($productInfo['product']);

		if (isset($productInfo['qty'])) {
			\PHPUnit_Framework_Assert::assertEquals(
				$productInfo['qty'],
				$formData['quantity_and_stock_status']['qty'],
				"Manage Stocks - Product qty is wrong"
			);
		}

		if (isset($productInfo['inStock'])) {
			if ($productInfo['inStock']) {
				\PHPUnit_Framework_Assert::assertEquals(
					'In Stock',
					$formData['quantity_and_stock_status']['is_in_stock'],
					"Manage Stocks - Product stock status is wrong"
				);
			} else {
				\PHPUnit_Framework_Assert::assertEquals(
					'Out of Stock',
					$formData['quantity_and_stock_status']['is_in_stock'],
					"Manage Stocks - Product stock status is wrong"
				);
			}
		}
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Manage Stocks - Product is updated in backend";
	}
}