<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 03/01/2018
 * Time: 15:31
 */

namespace Magento\Webpos\Test\TestStep;

use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\TestStep\TestStepInterface;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class ChangeCustomerOnCartStep
 * @package Magento\Webpos\Test\TestStep
 */
class ChangeCustomerOnCartStep implements TestStepInterface
{
	/**
	 * Webpos Index page.
	 * @var WebposIndex
	 */
	protected $webposIndex;

	/**
	 * @var Customer
	 */
	protected $customer;

	/**
	 * AddProductToCartStep constructor.
	 * @param WebposIndex $webposIndex
	 */
	public function __construct(
		WebposIndex $webposIndex,
		Customer $customer
	)
	{
		$this->webposIndex = $webposIndex;
		$this->customer = $customer;
	}

	/**
	 * @return mixed|void
	 */
	public function run()
	{
		$this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
		$this->webposIndex->getMsWebpos()->waitCartLoader();

		// Select an existing customer
		$this->webposIndex->getCheckoutCartHeader()->waitForElementVisible('.icon-iconPOS-change-customer');
		$this->webposIndex->getCheckoutCartHeader()->getIconAddCustomer()->click();

		$this->webposIndex->getCheckoutChangeCustomer()->search($this->customer->getEmail());
        $this->webposIndex->getCheckoutChangeCustomer()->waitForCustomerList();
		$this->webposIndex->getCheckoutChangeCustomer()->getFirstCustomer()->click();
		sleep(1);
		$this->webposIndex->getMsWebpos()->waitCheckoutLoader();
		$this->webposIndex->getMsWebpos()->waitCartLoader();
        sleep(1);
    }
}