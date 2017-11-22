<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 07/09/2017
 * Time: 14:56
 */

namespace Magento\Webpos\Test\Constraint\Location;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;

class AssertLocationNotInGrid extends AbstractConstraint
{
	/**
	 * Asserts that location is not in location's grid
	 *
	 * @param Location $location
	 * @param LocationIndex $locationIndex
	 * @return void
	 */
	public function processAssert(
		Location $location,
		LocationIndex $locationIndex
	) {
		$locationIndex->open();
		\PHPUnit_Framework_Assert::assertFalse(
			$locationIndex->getLocationGrid()->isRowVisible(['display_name' => $location->getDisplayName()]),
			'Location with name ' . $location->getDisplayName() . 'is present in Location grid.'
		);
	}

	/**
	 * Success message if Location not in grid
	 *
	 * @return string
	 */
	public function toString()
	{
		return 'Location is absent in Location grid.';
	}
}