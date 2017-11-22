<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 27/10/2017
 * Time: 10:30
 */

namespace Magento\Webpos\Test\Constraint\Synchronization\Category;

use Magento\Catalog\Test\Fixture\Category;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertCategoryIsInCategoryList extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex, Category $category, $action = '')
	{
		$webposIndex->open();
		$webposIndex->getCheckoutPage()->getAllCategoryButton()->click();
		sleep(1);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutPage()->getCategoryItem($category->getName())->isVisible(),
			"Synchronization - Category - ".$action." - Category '".$category->getName()."'is not shown in category list"
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Synchronization - Category - Category is displayed in category list correctly";
	}
}