<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 03/11/2017
 * Time: 08:49
 */

namespace Magento\Webpos\Test\Constraint\Synchronization\Country;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertCountryListUpdated extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex, $countryList, $action = '')
	{
		$webposIndex->open();
		$webposIndex->getMsWebpos()->clickCMenuButton();
		$webposIndex->getCMenu()->customerList();
		sleep(1);
		$webposIndex->getCustomerListContainer()->clickAddAddress()->click();
		$webposIndex->getCustomerListContainer()->clickAddCountry()->click();
		sleep(1);
		foreach ($countryList as $item) {
			\PHPUnit_Framework_Assert::assertTrue(
				$webposIndex->getCustomerListContainer()->getCountryItem($item)->isVisible(),
				'Synchronization - Country - '.$action.' - Allowed Country ('.$item.') is absent in country list'
			);
		}
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Synchronization - Country - Country list is updated";
	}
}