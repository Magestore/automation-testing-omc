<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 25/09/2017
 * Time: 08:02
 */

namespace Magento\Webpos\Test\TestCase\ManageStocks;


use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposManageStocksUpdateMS11Test extends Injectable
{
	protected $webposIndex;

	public function __inject(
		WebposIndex $webposIndex
	)
	{
		$this->webposIndex = $webposIndex;
	}

	public function test(Staff $staff)
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
		$product['sku'] = $this->webposIndex->getManageStocks()->getProductSKU($num);
		$product['qty'] = $this->webposIndex->getManageStocks()->getQtyInput($num)->getValue();

		$this->webposIndex->getMsWebpos()->clickCMenuButton();
		$this->webposIndex->getCMenu()->checkout();

		$this->webposIndex->getCheckoutPage()->search($product['sku']);
		$this->webposIndex->getCheckoutPage()->clickFirstProduct();
		$this->webposIndex->getCheckoutPage()->clickCheckoutButton();
		$this->webposIndex->getCheckoutPage()->selectPayment();
		$this->webposIndex->getCheckoutPage()->clickPlaceOrder();

		self::assertEquals(
			'Order has been created successfully',
			$this->webposIndex->getCheckoutPage()->getNotifyOrderText(),
			'MS11 - order place failed.'
		);

		$this->webposIndex->getCheckoutPage()->clickNewOrderButton();

		$this->webposIndex->getMsWebpos()->clickCMenuButton();
		$this->webposIndex->getCMenu()->manageStocks();

		$qty = $this->webposIndex->getManageStocks()->getQtyInput($num)->getValue();
		self::assertEquals(
			(int)$product['qty'] - 2,
			(int)$qty,
			'Product Qty update failed'
			."\nQty before checkout: " . $product['qty']
			. "\nQty Expected: " . ((int)$product['qty'] - 2)
			. "\nActual: " . $qty
		);

//		return ['products' => $products];
	}
}
