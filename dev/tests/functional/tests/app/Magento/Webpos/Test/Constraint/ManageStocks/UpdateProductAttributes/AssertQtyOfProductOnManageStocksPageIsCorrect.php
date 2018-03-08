<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 07/03/2018
 * Time: 09:30
 */

namespace Magento\Webpos\Test\Constraint\ManageStocks\UpdateProductAttributes;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertQtyOfProductOnManageStocksPageIsCorrect extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex, $productInfo, $expectQty)
	{
		// Login webpos
		$staff = $this->objectManager->getInstance()->create(
			'Magento\Webpos\Test\TestStep\LoginWebposStep'
		)->run();

		$webposIndex->getMsWebpos()->clickCMenuButton();
		$webposIndex->getCMenu()->manageStocks();
		sleep(2);
		$productName = $productInfo['product']->getName();

		// Edit product info
		$webposIndex->getManageStockList()->searchProduct($productName);
		$webposIndex->getManageStockList()->getStoreAddress()->click();
		sleep(2);
		\PHPUnit_Framework_Assert::assertEquals(
			$expectQty,
			$webposIndex->getManageStockList()->getProductQtyInput($productName)->getValue(),
			"Manage Stocks - Qty of product '".$productName."' is wrong"
		);

	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Manage Stocks - Qty of product is correct";
	}
}