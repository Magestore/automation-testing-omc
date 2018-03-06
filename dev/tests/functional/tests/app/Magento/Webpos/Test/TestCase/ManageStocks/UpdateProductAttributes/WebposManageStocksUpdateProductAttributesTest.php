<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 06/03/2018
 * Time: 08:22
 */

namespace Magento\Webpos\Test\TestCase\ManageStocks\UpdateProductAttributes;


use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposManageStocksUpdateProductAttributesTest extends Injectable
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
		$productInfo,
		$action = ''
	)
	{
		// Create product
		$productInfo['product'] = $this->fixtureFactory->createByCode('catalogProductSimple', ['dataset' => $productInfo['product']]);
		$productInfo['product']->persist();

		// Login webpos
		$staff = $this->objectManager->getInstance()->create(
			'Magento\Webpos\Test\TestStep\LoginWebposStep'
		)->run();

		$this->webposIndex->getMsWebpos()->clickCMenuButton();
		$this->webposIndex->getCMenu()->manageStocks();
		sleep(2);

		$productName = $productInfo['product']->getName();

		// Edit product info
		$this->webposIndex->getManageStockList()->searchProduct($productName);

		if (isset($productInfo['qty'])) {
			$this->webposIndex->getManageStockList()->getProductQtyInput($productName)->setValue($productInfo['qty']);
		}
		if (isset($productInfo['inStock'])) {
			$inStockCheckbox = $this->webposIndex->getManageStockList()->getProductInStockCheckbox($productName);
			$this->webposIndex->getManageStockList()->setCheckboxValue($inStockCheckbox, $productInfo['inStock']);
		}
		if (isset($productInfo['manageStock'])) {
			$manageStockCheckbox = $this->webposIndex->getManageStockList()->getProductManageStocksCheckbox($productName);
			$this->webposIndex->getManageStockList()->setCheckboxValue($manageStockCheckbox, $productInfo['manageStock']);
		}
		if (isset($productInfo['backorders'])) {
			$backordersCheckbox = $this->webposIndex->getManageStockList()->getProductBackOrdersCheckbox($productName);
			$this->webposIndex->getManageStockList()->setCheckboxValue($backordersCheckbox, $productInfo['backorders']);
		}

		// action
		if ($action === 'update') {
			$this->webposIndex->getManageStockList()->getUpdateButton($productName)->click();
			$this->webposIndex->getManageStockList()->waitForProductIconSuccess($productName);
		}

		return [
			'productInfo' => $productInfo
		];
	}
}