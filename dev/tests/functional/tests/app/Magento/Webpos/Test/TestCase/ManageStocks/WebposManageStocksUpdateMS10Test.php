<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 25/09/2017
 * Time: 08:52
 */

namespace Magento\Webpos\Test\TestCase\ManageStocks;


use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Catalog\Test\Page\Adminhtml\CatalogProductEdit;
use Magento\Catalog\Test\Page\Adminhtml\CatalogProductIndex;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;


class WebposManageStocksUpdateMS10Test extends Injectable
{
	protected $webposIndex;
	protected $productGrid;
	protected $editProductPage;

	public function __inject(
		WebposIndex $webposIndex,
		CatalogProductIndex $productGrid,
		CatalogProductEdit $editProductPage
	)
	{
		$this->webposIndex = $webposIndex;
		$this->productGrid = $productGrid;
		$this->editProductPage = $editProductPage;
	}

	public function test(Staff $staff, CatalogProductSimple $product)
	{

		$this->webposIndex->open();
		if ($this->webposIndex->getLoginForm()->isVisible()) {
			$this->webposIndex->getLoginForm()->fill($staff);
			$this->webposIndex->getLoginForm()->clickLoginButton();
			sleep(5);
			while ($this->webposIndex->getFirstScreen()->isVisible()) {
			}
			sleep(2);
		}

		$this->webposIndex->getMsWebpos()->clickCMenuButton();
		$this->webposIndex->getCMenu()->manageStocks();

		$num = 1;
		self::assertNotFalse(
			$this->webposIndex->getManageStocks()->getProduct($num)->isVisible(),
			"MS11 - product list don't have product"
		);

		$productSKU = $this->webposIndex->getManageStocks()->getProductSKU($num);

		$filter = ['sku' => $productSKU];

		$this->productGrid->open();
		$this->productGrid->getProductGrid()->searchAndOpen($filter);
		$this->editProductPage->getProductForm()->fill($product);
		$this->editProductPage->getFormPageActions()->save();

		$this->webposIndex->open();
		if ($this->webposIndex->getLoginForm()->isVisible()) {
			$this->webposIndex->getLoginForm()->fill($staff);
			$this->webposIndex->getLoginForm()->clickLoginButton();
			sleep(15);
			while ($this->webposIndex->getFirstScreen()->isVisible()) {
			}
			sleep(2);
		}

		$this->webposIndex->getMsWebpos()->clickCMenuButton();
		$this->webposIndex->getCMenu()->synchronization();
		sleep(1);

		$this->webposIndex->getSynchronization()->getStockUpdateButton()->click();

		sleep(1);

		self::assertTrue(
			$this->webposIndex->getSynchronization()->getStockItemProgress()->isVisible(),
			'MS10 - Stock Item update Progress is not showed'
		);
		self::assertTrue(
			$this->webposIndex->getSynchronization()->getProductProgress()->isVisible(),
			"MS10 - Product don't auto update"
		);
		$this->webposIndex->getSynchronization()->waitForElementVisible('#sync_container > div > main > table > tbody > tr:nth-child(5) > td.stock_item.process-box > div > span');
		$this->webposIndex->getSynchronization()->waitForElementVisible('#sync_container > div > main > table > tbody > tr:nth-child(4) > td.product.process-box > div > span');

		$this->webposIndex->getMsWebpos()->clickCMenuButton();
		$this->webposIndex->getCMenu()->manageStocks();
		sleep(1);

		$productName = $this->webposIndex->getManageStocks()->getProductName($num);
		self::assertEquals(
			$product->getName(),
			$productName,
			"MS10 - Product name isn't updated"
			. "\nExpected: " . $product->getName()
			. "\nActual: " . $productName
		);
		$qty = $this->webposIndex->getManageStocks()->getQtyInput($num)->getValue();
		self::assertEquals(
			$product->getQuantityAndStockStatus()['qty'],
			$qty,
			"MS10 - Product qty isn't updated"
			. "\nExpected: " . $product->getQuantityAndStockStatus()['qty']
			. "\nActual: " . $qty
		);

	}
}
