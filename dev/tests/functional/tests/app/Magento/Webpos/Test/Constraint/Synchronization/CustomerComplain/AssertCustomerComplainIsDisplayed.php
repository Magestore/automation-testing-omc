<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 01/11/2017
 * Time: 14:30
 */
namespace Magento\Webpos\Test\Constraint\Synchronization\CustomerComplain;

use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Fixture\CustomerComplain;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertCustomerComplainIsDisplayed extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex, CustomerComplain $customerComplain, $action = '')
	{
		$webposIndex->open();
		$webposIndex->getMsWebpos()->clickCMenuButton();
		$webposIndex->getCMenu()->customerList();
		sleep(1);
		$webposIndex->getCustomerListContainer()->searchCustomer()->setValue($customerComplain->getCustomerEmail());
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCustomerListContainer()->getFirstCustomer()->isVisible(),
			'Synchronization - Customer Complain - '.$action.' - Customer list is empty'
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCustomerListContainer()->customerComplainIsVisible($customerComplain->getContent()),
			'Synchronization - Customer Complain - '.$action.' - Complain is not shown is complains list'
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Synchronization - Customer Complain - Complain is shown on customer detail page";
	}
}
