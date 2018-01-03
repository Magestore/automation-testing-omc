<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 03/01/2018
 * Time: 16:03
 */

namespace Magento\Webpos\Test\TestStep;


use Magento\Mtf\TestStep\TestStepInterface;
use Magento\Webpos\Test\Page\WebposIndex;

class PlaceOrderSetShipAndCreateInvoiceSwitchStep implements TestStepInterface
{
	/**
	 * Webpos Index page.
	 * @var WebposIndex
	 */
	protected $webposIndex;

	protected $createInvoice = true;
	protected $shipped = false;

	/**
	 * AddProductToCartStep constructor.
	 * @param WebposIndex $webposIndex
	 * @param $products
	 */
	public function __construct(
		WebposIndex $webposIndex,
		$createInvoice,
		$shipped
	)
	{
		$this->webposIndex = $webposIndex;
		$this->createInvoice = $createInvoice;
		$this->shipped = $shipped;
	}

	/**
	 * @return mixed|void
	 */
	public function run()
	{
		$shippingCheckbox = $this->webposIndex->getCheckoutPlaceOrder()->getShippingCheckbox();
		if ($shippingCheckbox->isVisible()) {
			if ($this->shipped != $this->webposIndex->getCheckoutPlaceOrder()->isCheckboxChecked($shippingCheckbox)) {
				$shippingCheckbox->click();
			}
		}

		$createInvoiceCheckbox = $this->webposIndex->getCheckoutPlaceOrder()->getCreateInvoiceCheckbox();
		if ($createInvoiceCheckbox->isVisible()) {
			if ($this->createInvoice != $this->webposIndex->getCheckoutPlaceOrder()->isCheckboxChecked($createInvoiceCheckbox)) {
				$createInvoiceCheckbox->click();
			}
		}
	}
}