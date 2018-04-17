<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 09/03/2018
 * Time: 09:38
 */

namespace Magento\Webpos\Test\Constraint\ManageStocks\UpdateProductAttributes;


use Magento\Catalog\Test\Page\Adminhtml\CatalogProductEdit;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Class AssertProductsAreUpdatedInBackend
 * @package Magento\Webpos\Test\Constraint\ManageStocks\UpdateProductAttributes
 */
class AssertProductsAreUpdatedInBackend extends AbstractConstraint
{
	/**
	 * @param CatalogProductEdit $catalogProductEdit
	 * @param AssertProductIsUpdatedInBackend $assertProductIsUpdatedInBackend
	 * @param $productList
	 */
	public function processAssert(
		CatalogProductEdit $catalogProductEdit,
		AssertProductIsUpdatedInBackend $assertProductIsUpdatedInBackend,
		$productList
	)
	{
		foreach ($productList as $item) {
			$assertProductIsUpdatedInBackend->processAssert($catalogProductEdit, $item);
		}
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Manage Stocks - Products are updated in backend";
	}
}