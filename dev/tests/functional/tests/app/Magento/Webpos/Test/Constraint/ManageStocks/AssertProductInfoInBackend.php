<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 22/09/2017
 * Time: 09:31
 */

namespace Magento\Webpos\Test\Constraint\ManageStocks;

use Magento\Catalog\Test\Page\Adminhtml\CatalogProductIndex;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertProductInfoInBackend extends AbstractConstraint
{

	public function processAssert(WebposIndex $webposIndex, CatalogProductIndex $productGrid, $products)
	{
		$i = 1;
		foreach ($products as $item) {
			\PHPUnit_Framework_Assert::assertFalse(
				$webposIndex->getManageStocks()->getUpdateButton($i)->isVisible(),
				'MS06 - update button is not hided'
			);
			\PHPUnit_Framework_Assert::assertNotFalse(
				$webposIndex->getManageStocks()->getUpdateSuccessIcon($i)->isVisible(),
				'MS06 - update success icon is not showed'
			);
			$i++;
		}
		$productGrid->open();
		foreach ($products as $item) {

			$filter = ['sku' => $item['sku'], 'qty_from' => $item['qty']];
			\PHPUnit_Framework_Assert::assertTrue(
				$productGrid->getProductGrid()->isRowVisible($filter, true, false),
				'MS06 - Product is not updated in backend'
			);
		}
		$productGrid->getProductGrid()->resetFilter();
	}
	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return 'Product info updated in backend';
	}
}