<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 09/03/2018
 * Time: 08:00
 */

namespace Magento\Webpos\Test\TestCase\ManageStocks\UpdateProductAttributes;


use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposManageStocksUpdateProductAttributesMSK09Test extends Injectable
{
	/**
	 * @var WebposIndex
	 */
	protected $webposIndex;

	/**
	 * @var FixtureFactory
	 */
	protected $fixtureFactory;

	public function __inject(
		WebposIndex $webposIndex,
		FixtureFactory $fixtureFactory
	)
	{
		$this->webposIndex = $webposIndex;
		$this->fixtureFactory = $fixtureFactory;
	}

	public function test(
		$productList
	)
	{
		// Create product
		foreach ($productList as $key => $item) {
			$productList[$key]['product'] = $this->objectManager->getInstance()->create(
				'Magento\Webpos\Test\TestStep\CreateNewProductByCurlStep',
				[
					'productData' => $productList[$key]['product']
				]
			)->run();
		}

		// Login webpos
		$staff = $this->objectManager->getInstance()->create(
			'Magento\Webpos\Test\TestStep\LoginWebposStep'
		)->run();

		$this->webposIndex->getMsWebpos()->clickCMenuButton();
		$this->webposIndex->getCMenu()->manageStocks();
		sleep(2);

		$this->webposIndex->getManageStockList()->searchProduct('Simple Product MSK09');
		$this->webposIndex->getManageStockList()->getStoreAddress()->click();
		sleep(5);

		foreach ($productList as $item) {

			$productName = $item['product']->getName();

			// Edit product info

			if (isset($item['qty'])) {
				$this->webposIndex->getManageStockList()->getProductQtyInput($productName)->setValue($item['qty']);
			}
			if (isset($item['inStock'])) {
				$inStockCheckbox = $this->webposIndex->getManageStockList()->getProductInStockCheckbox($productName);
				$this->webposIndex->getManageStockList()->setCheckboxValue($inStockCheckbox, $item['inStock']);
			}
			if (isset($item['manageStock'])) {
				$manageStockCheckbox = $this->webposIndex->getManageStockList()->getProductManageStocksCheckbox($productName);
				$this->webposIndex->getManageStockList()->setCheckboxValue($manageStockCheckbox, $item['manageStock']);
			}
			if (isset($item['backorders'])) {
				$backordersCheckbox = $this->webposIndex->getManageStockList()->getProductBackOrdersCheckbox($productName);
				$this->webposIndex->getManageStockList()->setCheckboxValue($backordersCheckbox, $item['backorders']);
			}
		}

		// action
		$this->webposIndex->getManageStockList()->getUpdateAllButton()->click();
            foreach ($productList as $item) {
			$productName = $item['product']->getName();
			$this->webposIndex->getManageStockList()->waitForProductIconSuccess($productName);
		}

		return [
			'productList' => $productList
		];
	}
}