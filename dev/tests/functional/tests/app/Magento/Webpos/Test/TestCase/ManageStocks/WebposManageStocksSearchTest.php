<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 20/09/2017
 * Time: 15:51
 */

namespace Magento\Webpos\Test\TestCase\ManageStocks;


use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposManageStocksSearchTest extends Injectable
{
	protected $webposIndex;

	public function __inject(
		WebposIndex $webposIndex
	)
	{
		$this->webposIndex = $webposIndex;
	}

	public function test(Staff $staff, $name, $sku)
	{
		$this->webposIndex->open();
		if ($this->webposIndex->getLoginForm()->isVisible()){
			$this->webposIndex->getLoginForm()->fill($staff);
			$this->webposIndex->getLoginForm()->clickLoginButton();
			sleep(5);
			while ($this->webposIndex->getFirstScreen()->isVisible()) {}
			sleep(2);
		}

		$this->webposIndex->getMsWebpos()->clickCMenuButton();
		$this->webposIndex->getCMenu()->manageStocks();
		//MS01
		self::assertNotFalse(
			$this->webposIndex->getManageStocks()->isVisible(),
			'MS01 Manage Stocks page is not visibled'
		);

		//MS02
		$this->webposIndex->getManageStocks()->search('ajkjabvjhhjva');

		self::assertFalse(
			$this->webposIndex->getManageStocks()->getProduct(1)->isVisible(),
			'MS02 - Product list not empty'
		);
		//MS04
		$this->webposIndex->getManageStocks()->search('');
		self::assertNotFalse(
			$this->webposIndex->getManageStocks()->getProduct(1)->isVisible(),
			"MS04 - product list is not show all product"
		);

		//MS03
		// search name
		$this->webposIndex->getManageStocks()->search($name);
		self::assertNotFalse(
			$this->webposIndex->getManageStocks()->getProduct(1)->isVisible(),
			"MS03 - search name - can't find product"
		);
		self::assertContains(
			$name,
			$this->webposIndex->getManageStocks()->getProductName(1),
			'MS03 - search name - product name is not contain string'
		);
		// search sku
		$this->webposIndex->getManageStocks()->search($sku);
		self::assertNotFalse(
			$this->webposIndex->getManageStocks()->getProduct(1)->isVisible(),
			"MS03 - search sku - can't find product"
		);
		self::assertContains(
			$sku,
			$this->webposIndex->getManageStocks()->getProductSKU(1),
			'MS03 - search sku - product SKU is not contain string'
		);
	}
}
