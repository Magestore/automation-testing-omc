<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 24/11/2017
 * Time: 17:07
 */

namespace Magento\BarcodeSuccess\Test\Constraint\Adminhtml\BarcodeListing\Form;


use Magento\BarcodeSuccess\Test\Page\Adminhtml\BarcodeListing\BarcodeImportIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertOpenImportBarcodeFormIsAvailable extends AbstractConstraint
{
	public function processAssert(BarcodeImportIndex $barcodeImportIndex, $form, $firstField)
	{
        \PHPUnit_Framework_Assert::assertTrue(
            $barcodeImportIndex->getFormBarcodeImport()->getForm($form)->isVisible(),
            'Form '.$form.' is not exist'
        );
		\PHPUnit_Framework_Assert::assertTrue(
            $barcodeImportIndex->getFormBarcodeImport()->getFirstField($firstField)->isVisible(),
			'Field '.$firstField.' is not shown'
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