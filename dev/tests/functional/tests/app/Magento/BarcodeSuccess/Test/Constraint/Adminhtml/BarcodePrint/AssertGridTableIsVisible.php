<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 24/11/2017
 * Time: 10:07
 */

namespace Magento\BarcodeSuccess\Test\Constraint\Adminhtml\BarcodePrint;


use Magento\BarcodeSuccess\Test\Page\Adminhtml\BarcodePrint\BarcodePrintIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertGridTableIsVisible extends AbstractConstraint
{
	public function processAssert(BarcodePrintIndex $barcodePrintIndex, $tableGrid)
	{
	    $barcodePrintIndex->getBarcodeGrid()->waitingForLoadingMaskNotVisible();
        $barcodePrintIndex->getBarcodeGrid()->waitingForLoadingMaskFormNotVisible();
        \PHPUnit_Framework_Assert::assertTrue(
            $barcodePrintIndex->getPrintBarcodeGrid()->tableIsVisible($tableGrid),
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