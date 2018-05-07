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

	protected $createInvoice;
	protected $shipped;

	/**
	 * PlaceOrderSetShipAndCreateInvoiceSwitchStep constructor.
	 * @param WebposIndex $webposIndex
	 * @param bool $createInvoice
	 * @param bool $shipped
	 */
	public function __construct(
		WebposIndex $webposIndex,
		$createInvoice = true,
		$shipped = false
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
                $this->webposIndex->getCheckoutPlaceOrder()->waitForShippingCheckboxVisible();
                $this->webposIndex->getMsWebpos()->waitCartLoader();
                $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
                $shippingCheckbox->click();
			}
		}

		$createInvoiceCheckbox = $this->webposIndex->getCheckoutPlaceOrder()->getCreateInvoiceCheckbox();
        if ($createInvoiceCheckbox->isVisible()) {
            if ($this->webposIndex->getCheckoutPlaceOrder()->isCheckboxChecked($createInvoiceCheckbox) != $this->createInvoice) {
                $this->webposIndex->getCheckoutPlaceOrder()->waitForCreateInvoiceCheckboxVisible();
                $this->webposIndex->getMsWebpos()->waitCartLoader();
                $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
                $createInvoiceCheckbox->click();
			}
		}
	}
}