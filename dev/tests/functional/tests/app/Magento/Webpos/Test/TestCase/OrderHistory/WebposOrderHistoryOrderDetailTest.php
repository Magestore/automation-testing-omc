<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 02/10/2017
 * Time: 11:18
 */

namespace Magento\Webpos\Test\TestCase\OrderHistory;


use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposOrderHistoryOrderDetailTest extends Injectable
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
		$sku,
		$discountPercent = null,
		$amount = null,
		$remain = null,
		$shipped = false,
		$paid = true,
		$expectedStatus = null,
		$actions = null
	)
	{
		$this->webposIndex->open();
		if ($this->webposIndex->getLoginForm()->isVisible()){
			$this->webposIndex->getLoginForm()->fill($staff);
			$this->webposIndex->getLoginForm()->clickLoginButton();
			sleep(5);
			while ($this->webposIndex->getFirstScreen()->isVisible()) {

			}
			sleep(2);
		}

//		while (!$this->webposIndex->getCheckoutPage()->getProductList()->isVisible()) {}
//		$this->webposIndex->getCheckoutPage()->clickFirstProduct();
		$this->webposIndex->getCheckoutPage()->search($sku);

		if (!empty($discountPercent)) {
			$this->webposIndex->getCheckoutPage()->getAddDiscount()->click();
			self::assertTrue(
				$this->webposIndex->getCheckoutPage()->getAddDiscountPopup()->isVisible(),
				'Add discount popup is not showed'
			);
			$this->webposIndex->getCheckoutPage()->setDiscountPercent($discountPercent);
			$this->webposIndex->getCheckoutPage()->clickDiscountApplyButton();
		}

		$this->webposIndex->getCheckoutPage()->clickCheckoutButton();

		$result['total'] = $this->webposIndex->getCheckoutPage()->getTotal2();
		$result['total'] = substr($result['total'], 1);

		if ($this->webposIndex->getCheckoutPage()->getPaymentContainer()->isVisible()) {
			$this->webposIndex->getCheckoutPage()->selectPayment();
			if (!empty($amount)) {
				$this->webposIndex->getCheckoutPage()->setPaidAmount($amount);
			}
			$this->webposIndex->getCheckoutPage()->getRemainMoney()->click();
			sleep(1);
			$result['remain-money'] = $this->webposIndex->getCheckoutPage()->getRemainMoney()->getText();
			$result['remain-money'] = substr($result['remain-money'], 1);
		}
		$shippingCheckbox = $this->webposIndex->getCheckoutPage()->getShippingCheckbox();
		if ($shippingCheckbox->isVisible()) {
			if ($shipped != $this->webposIndex->getCheckoutPage()->isCheckboxChecked($shippingCheckbox)) {
				$shippingCheckbox->click();
			}
		}

		$paidCheckbox = $this->webposIndex->getCheckoutPage()->getPaidCheckbox();
		if ($paidCheckbox->isVisible()) {
			if ($paid != $this->webposIndex->getCheckoutPage()->isCheckboxChecked($paidCheckbox)) {
				$paidCheckbox->click();
			}
		}
		$this->webposIndex->getCheckoutPage()->clickPlaceOrder();

		self::assertEquals(
			'Order has been created successfully',
			$this->webposIndex->getCheckoutPage()->getNotifyOrderText(),
			'order place failed.'
		);
		$result['orderId'] = $this->webposIndex->getCheckoutPage()->getOrderId();
		$result['orderId'] = substr($result['orderId'], 1);

		$this->webposIndex->getCheckoutPage()->clickNewOrderButton();


		return [
			'expectedStatus' => $expectedStatus,
			'amount' => $amount,
			'remain' => $remain,
			'actions' => $actions,
			'result' => $result
		];
	}
}