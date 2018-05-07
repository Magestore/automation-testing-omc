<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 25/01/2018
 * Time: 10:25
 */

namespace Magento\Webpos\Test\TestStep;


use Magento\Mtf\TestStep\TestStepInterface;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AddPaymentOnCheckoutPageStep
 * @package Magento\Webpos\Test\TestStep
 */
class AddPaymentOnCheckoutPageStep implements TestStepInterface
{
	/**
	 * Webpos Index page.
	 * @var WebposIndex
	 */
	protected $webposIndex;

	/**
	 * @var
	 */
	protected $paymentMethods;


	/**
	 * AddPaymentOnCheckoutPageStep constructor.
	 * @param WebposIndex $webposIndex
	 * @param $paymentMethods
	 */
	public function __construct(
		WebposIndex $webposIndex,
		$paymentMethods
	)
	{
		$this->webposIndex = $webposIndex;
		$this->paymentMethods = $paymentMethods;
	}

	/**
	 * @return mixed
	 */
	public function run()
	{
		foreach ($this->paymentMethods as $key => $method) {
			$this->webposIndex->getCheckoutPlaceOrder()->getButtonAddPayment()->click();
			$this->webposIndex->getCheckoutContainer()->waitForAddMorePaymentModal();
			sleep(1);
			$this->webposIndex->getCheckoutAddMorePayment()->getPaymentMethodByLabel($method['label'])->click();
			$this->webposIndex->getMsWebpos()->waitCheckoutLoader();

			if (isset($method['amount'])) {
				$this->webposIndex->getCheckoutPaymentMethod()->getPaymentSelectedItemAmountInput($method['label'])->setValue($method['amount']);
				$this->webposIndex->getCheckoutPlaceOrder()->getRemainMoney()->click();
				sleep(1);
			} else {
				$this->paymentMethods[$key]['amount'] = $this->webposIndex->getCheckoutPaymentMethod()->getPaymentSelectedItemAmountInput($method['label'])->getValue();
				$this->paymentMethods[$key]['amount'] = (float)substr($this->paymentMethods[$key]['amount'], 1);
			}
		}

		return $this->paymentMethods;

	}
}