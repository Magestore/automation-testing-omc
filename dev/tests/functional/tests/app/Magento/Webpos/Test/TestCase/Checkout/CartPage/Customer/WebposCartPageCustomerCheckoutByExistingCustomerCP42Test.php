<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 11/12/2017
 * Time: 08:18
 */

namespace Magento\Webpos\Test\TestCase\Checkout\CartPage\Customer;


use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposCartPageCustomerCheckoutByExistingCustomerCP42Test extends Injectable
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
		CatalogProductSimple $product,
		Customer $customer
	)
	{
		//Prepare customers
		$customer->persist();

		// Login webpos
		$this->objectManager->getInstance()->create(
			'Magento\Webpos\Test\TestStep\LoginWebposStep',
			['staff' => $staff]
		)->run();

		$this->webposIndex->getCheckoutProductList()->waitProductListToLoad();

		$this->webposIndex->getCheckoutProductList()->search($product->getName());
		$this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
		$this->webposIndex->getMsWebpos()->waitCartLoader();

		// Select an existing customer
		$this->webposIndex->getCheckoutCartHeader()->getIconAddCustomer()->click();
		self::assertTrue(
			$this->webposIndex->getCheckoutChangeCustomer()->isVisible(),
			'Checkout - Cart Page - Change customer popup is not shown'
		);
		$this->webposIndex->getCheckoutChangeCustomer()->search($customer->getEmail());
		sleep(1);
		$this->webposIndex->getCheckoutChangeCustomer()->getFirstCustomer()->click();
		sleep(1);

		$this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
		$this->webposIndex->getMsWebpos()->waitCartLoader();
		$this->webposIndex->getMsWebpos()->waitCheckoutLoader();
	}
}