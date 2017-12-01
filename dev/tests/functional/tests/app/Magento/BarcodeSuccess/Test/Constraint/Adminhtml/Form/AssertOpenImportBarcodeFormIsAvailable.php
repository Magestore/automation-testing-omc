<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 24/11/2017
 * Time: 17:07
 */

namespace Magento\BarcodeSuccess\Test\Constraint\Adminhtml\Form;


use Magento\BarcodeSuccess\Test\Page\Adminhtml\BarcodeImportIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertOpenImportBarcodeFormIsAvailable extends AbstractConstraint
{
	public function processAssert(BarcodeImportIndex $barcodeImportIndex)
	{
		$barcodeImportIndex->getFormBarcodeImport()->waitPageToLoad();
        \PHPUnit_Framework_Assert::assertTrue(
            $barcodeImportIndex->getFormBarcodeImport()->getForm()->isVisible(),
            'Form is not exist'
        );
		\PHPUnit_Framework_Assert::assertTrue(
            $barcodeImportIndex->getFormBarcodeImport()->getFirstFieldForm()->isVisible(),
			'Field Reason is not shown'
		);

	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Import Form is available";
	}
}