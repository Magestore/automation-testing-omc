<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 28/09/2017
 * Time: 13:54
 */

namespace Magento\Webpos\Test\TestCase\Settings;


use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposSettingsGeneralCatalogTest extends Injectable
{
	protected $webposIndex;

	public function __inject(
		WebposIndex $webposIndex
	)
	{
		$this->webposIndex = $webposIndex;
	}

	public function test(
		Staff $staff,
		$outstockDisplay,
		$setInStock = false
	)
	{
		$this->webposIndex->open();
		if ($this->webposIndex->getLoginForm()->isVisible()){
			$this->webposIndex->getLoginForm()->fill($staff);
			$this->webposIndex->getLoginForm()->clickLoginButton();
			sleep(5);
			while ($this->webposIndex->getFirstScreen()->isVisible()) {}
			sleep(2);
		}

		sleep(2);
		// Prepare out of stocks products
		$this->webposIndex->getMsWebpos()->clickCMenuButton();
		$this->webposIndex->getCMenu()->manageStocks();
		$count = 3;
		for ($i = 1; $i <= $count; $i++) {
			$this->webposIndex->getManageStocks()->getQtyInput($i)->setValue(0);
			$inStockCheckbox = $this->webposIndex->getManageStocks()->getInStockCheckbox($i);
			if (false != $this->webposIndex->getManageStocks()->isCheckboxChecked($inStockCheckbox)) {
				$inStockCheckbox->click();
			}

			$products[] = $this->webposIndex->getManageStocks()->getProductSKU($i);
		}
		$this->webposIndex->getManageStocks()->getUpdateAllButton()->click();

		// start
		$this->webposIndex->getMsWebpos()->clickCMenuButton();
		$this->webposIndex->getCMenu()->general();

		self::assertTrue(
			$this->webposIndex->getGeneral()->isVisible(),
			'Settings - General page is not displayed'
		);
		self::assertTrue(
			$this->webposIndex->getGeneral()->getCatalogTab()->isVisible(),
			'Settings - General - Catalog Tab is not displayed'
		);
		self::assertTrue(
			$this->webposIndex->getGeneral()->getCurrencyTab()->isVisible(),
			'Settings - General - Currency is not displayed'
		);

		self::assertTrue(
			$this->webposIndex->getGeneral()->getOutstockDisplay()->isVisible(),
			'Outstock Display select box is not displayed'
		);
		$this->webposIndex->getGeneral()->selectOutstockDisplay($outstockDisplay);

		if ($setInStock) {
			$this->webposIndex->getMsWebpos()->clickCMenuButton();
			$this->webposIndex->getCMenu()->manageStocks();
			sleep(2);
			for ($i = 1; $i <= $count; $i++) {
				$this->webposIndex->getManageStocks()->getQtyInput($i)->setValue(100);
				$inStockCheckbox = $this->webposIndex->getManageStocks()->getInStockCheckbox($i);
				if (true != $this->webposIndex->getManageStocks()->isCheckboxChecked($inStockCheckbox)) {
					$inStockCheckbox->click();
				}
			}
			$this->webposIndex->getManageStocks()->getUpdateAllButton()->click();
		}

		return ['products' => $products];
	}

	protected function tearDown()
	{
		$this->webposIndex->getMsWebpos()->clickCMenuButton();
		$this->webposIndex->getCMenu()->manageStocks();
		$count = 3;
		sleep(2);
		for ($i = 1; $i <= $count; $i++) {
			$this->webposIndex->getManageStocks()->getQtyInput($i)->setValue(100);
			$inStockCheckbox = $this->webposIndex->getManageStocks()->getInStockCheckbox($i);
			if (true != $this->webposIndex->getManageStocks()->isCheckboxChecked($inStockCheckbox)) {
				$inStockCheckbox->click();
			}

//			$products[] = $this->webposIndex->getManageStocks()->getProductSKU($i);
		}
		$this->webposIndex->getManageStocks()->getUpdateAllButton()->click();
		sleep(3);
	}
}