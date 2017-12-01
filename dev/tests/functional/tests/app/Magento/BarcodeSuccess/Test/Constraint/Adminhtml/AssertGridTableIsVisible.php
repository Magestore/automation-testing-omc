<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 24/11/2017
 * Time: 10:07
 */

namespace Magento\BarcodeSuccess\Test\Constraint\Adminhtml;


use Magento\BarcodeSuccess\Test\Page\Adminhtml\BarcodePrintIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertGridTableIsVisible extends AbstractConstraint
{
	public function processAssert(BarcodePrintIndex $barcodePrintIndex)
	{
		$barcodePrintIndex->getFormBarcodePrintIndex()->waitPageToLoad();
		\PHPUnit_Framework_Assert::assertTrue(
            $barcodePrintIndex->getPrintBarcodeGrid()->TableIsVisible(),
			'Grid Table is not shown'
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Grid Table is visible";
	}
}