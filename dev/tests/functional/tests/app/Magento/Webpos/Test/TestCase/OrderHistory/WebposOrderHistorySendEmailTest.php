<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 04/10/2017
 * Time: 14:25
 */

namespace Magento\Webpos\Test\TestCase\OrderHistory;


use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposOrderHistorySendEmailTest extends Injectable
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
		Staff $staff
	)
	{
		$this->webposIndex->open();
		if ($this->webposIndex->getLoginForm()->isVisible()) {
			$this->webposIndex->getLoginForm()->fill($staff);
			$this->webposIndex->getLoginForm()->clickLoginButton();
			sleep(5);
			while ($this->webposIndex->getFirstScreen()->isVisible()) {}
			sleep(2);
		}

		$this->webposIndex->getCheckoutPage()->clickFirstProduct();
		$this->webposIndex->getCheckoutPage()->clickCheckoutButton();
		$this->webposIndex->getCheckoutPage()->selectPayment();
		$this->webposIndex->getCheckoutPage()->clickPlaceOrder();
		sleep(1);

		$this->webposIndex->getCheckoutPage()->clickNewOrderButton();

		$this->webposIndex->getMsWebpos()->clickCMenuButton();
		$this->webposIndex->getCMenu()->ordersHistory();

		sleep(2);
		$this->webposIndex->getOrdersHistory()->getFirstOrder()->click();

		while (strcmp($this->webposIndex->getOrdersHistory()->getStatus(), 'Not Sync') == 0) {}
		self::assertTrue(
			$this->webposIndex->getOrdersHistory()->getFirstOrder()->isVisible(),
			"Order List is empty"
		);
		$sendEmailText = 'Send Email';
		$this->webposIndex->getOrdersHistory()->getMoreInfoButton()->click();
		self::assertTrue(
			$this->webposIndex->getOrdersHistory()->getAction($sendEmailText)->isVisible(),
			'Order History - Send Email - Send Email Action is missed'
		);

		$this->webposIndex->getOrdersHistory()->getAction($sendEmailText)->click();

	}
}