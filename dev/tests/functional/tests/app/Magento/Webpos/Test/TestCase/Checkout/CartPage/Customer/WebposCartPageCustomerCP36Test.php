<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 08/12/2017
 * Time: 07:56
 */

namespace Magento\Webpos\Test\TestCase\Checkout\CartPage\Customer;


use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Checkout\CheckGUI\AssertWebposCheckoutPagePlaceOrderPageSuccessVisible;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposCartPageCustomerCP36Test extends Injectable
{
	/**
	 * @var WebposIndex
	 */
	protected $webposIndex;

	/**
	 * @var AssertWebposCheckoutPagePlaceOrderPageSuccessVisible
	 */
	protected $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;

	public function __inject(
		WebposIndex $webposIndex,
		AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
	)
	{
		$this->webposIndex = $webposIndex;
		$this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible = $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;
	}

	public function test(
		Staff $staff,
		CatalogProductSimple $product,
		Customer $customer
	)
	{
		$customer->persist();

		$this->webposIndex->open();
		if ($this->webposIndex->getLoginForm()->isVisible()) {
			$this->webposIndex->getLoginForm()->fill($staff);
			$this->webposIndex->getLoginForm()->clickLoginButton();
			sleep(5);
			while ($this->webposIndex->getFirstScreen()->isVisible()) {}
			sleep(2);
		}

		$this->webposIndex->getCheckoutProductList()->waitProductListToLoad();

		$this->webposIndex->getCheckoutProductList()->search($product->getName());
		$this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
		$this->webposIndex->getMsWebpos()->waitCartLoader();

		// Select Existing customer
		$this->webposIndex->getCheckoutCartHeader()->getIconAddCustomer()->click();
		self::assertTrue(
			$this->webposIndex->getCheckoutChangeCustomer()->isVisible(),
			'Checkout - Cart Page - Checkout by guest - Change customer popup is nt shown'
		);
		$this->webposIndex->getCheckoutChangeCustomer()->search($customer->getEmail());
		sleep(1);
		$this->webposIndex->getCheckoutChangeCustomer()->getFirstCustomer()->click();
		sleep(1);

		//Use Guest
		$this->webposIndex->getCheckoutCartHeader()->getIconAddCustomer()->click();
		self::assertTrue(
			$this->webposIndex->getCheckoutChangeCustomer()->isVisible(),
			'Checkout - Cart Page - Checkout by guest - Change customer popup is nt shown'
		);
		$this->webposIndex->getCheckoutChangeCustomer()->getUseGuestButton()->click();
		sleep(1);

		$this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
		$this->webposIndex->getMsWebpos()->waitCartLoader();
		$this->webposIndex->getMsWebpos()->waitCheckoutLoader();

		$this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
		$this->webposIndex->getMsWebpos()->waitCheckoutLoader();
		$this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
		$this->webposIndex->getMsWebpos()->waitCheckoutLoader();

		//Assert Place Order Success
		$this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible->processAssert($this->webposIndex);

		$this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
		$this->webposIndex->getMsWebpos()->waitCartLoader();
	}
}