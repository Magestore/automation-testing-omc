<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 09/10/2017
 * Time: 09:04
 */

namespace Magento\Webpos\Test\TestCase\OrderHistory;


use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposOrderHistoryShipmentCustomProductTest extends Injectable
{
	/**
	 * @var WebposIndex
	 */
	protected $webposIndex;

	public function __inject(
		WebposIndex $webposIndex
	)
	{
		$this->webposIndex = $webposIndex;
	}

	public function test(
		Staff $staff,
		$product,
		$submit = true,
		$confirmAction = null
	)
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

		$this->webposIndex->getCheckoutPage()->getCustomSaleButton()->click();

		self::assertTrue(
			$this->webposIndex->getCheckoutPage()->getPopupCustomSale()->isVisible(),
			'Custom Sale Popup is not showed'
		);

		$product['name'] = str_replace('%isolation%', rand(1, 9999999), $product['name']);
		$this->webposIndex->getCheckoutPage()->getCustomSaleProductNameInput()->setValue($product['name']);
		$this->webposIndex->getCheckoutPage()->getCustomSaleProductPriceInput()->setValue($product['price']);

		$shippableCheckbox = $this->webposIndex->getCheckoutPage()->getCustomSaleShipAbleCheckbox();
		if ($product['shippable'] != $this->webposIndex->getCheckoutPage()->isCheckboxChecked($shippableCheckbox)) {
			$shippableCheckbox->click();
		}

		$this->webposIndex->getCheckoutPage()->getCustomSaleAddToCartButton()->click();

		$this->webposIndex->getCheckoutPage()->clickCheckoutButton();
		sleep(1);
		$this->webposIndex->getCheckoutPage()->selectPayment();
		sleep(1);

		$this->webposIndex->getCheckoutPage()->clickPlaceOrder();
		sleep(1);
		$orderId = $this->webposIndex->getCheckoutPage()->getOrderId();
		$orderId = substr($orderId, 1);
		$this->webposIndex->getCheckoutPage()->clickNewOrderButton();

		$this->webposIndex->getMsWebpos()->clickCMenuButton();
		$this->webposIndex->getCMenu()->ordersHistory();

		sleep(1);
		$this->webposIndex->getOrdersHistory()->getFirstOrder()->click();

		while (strcmp($this->webposIndex->getOrdersHistory()->getStatus(), 'Not Sync') == 0) {}
		self::assertTrue(
			$this->webposIndex->getOrdersHistory()->getFirstOrder()->isVisible(),
			"Order List is empty"
		);

		return ['orderId' => $orderId];
	}
}