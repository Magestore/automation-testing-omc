<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 11/09/2017
 * Time: 08:39
 */

namespace Magento\Webpos\Test\Constraint\Pos;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Fixture\WebposPos;
use Magento\Webpos\Test\Page\Adminhtml\WebposPosIndex;

class AssertPosNotInGrid extends AbstractConstraint
{
	/**
	 * Asserts that pos is not in pos's grid
	 *
	 * @param WebposPos $webposPos
	 * @param WebposPosIndex $webposPosIndex
	 */
	public function processAssert(
		WebposPos $webposPos,
		WebposPosIndex $webposPosIndex
	) {
		$webposPosIndex->open();
		\PHPUnit_Framework_Assert::assertFalse(
			$webposPosIndex->getPosGrid()->isRowVisible(['pos_name' => $webposPos->getPosName()]),
			'Pos with name ' . $webposPos->getPosName() . 'is present in Pos grid.'
		);
	}

	/**
	 * Success message if Pos not in grid
	 *
	 * @return string
	 */
	public function toString()
	{
		return 'Pos is absent in Pos grid.';
	}
}