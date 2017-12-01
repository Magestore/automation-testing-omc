<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 27/11/2017
 * Time: 10:04
 */
namespace Magento\BarcodeSuccess\Test\Constraint\Adminhtml\Form;


use Magento\BarcodeSuccess\Test\Page\Adminhtml\BarcodeGenerateIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertOpenGenerateBarcodeFormIsAvailable extends AbstractConstraint
{
    public function processAssert(BarcodeGenerateIndex $barcodeGenerateIndex)
    {

    	$barcodeGenerateIndex->getFormBarcodeGenerate()->waitPageToLoad();
        \PHPUnit_Framework_Assert::assertTrue(
            $barcodeGenerateIndex->getFormBarcodeGenerate()->getSection('os_barcode_generate_form_general')->isVisible(),
            'Section os_barcode_generate_form_general is not shown'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $barcodeGenerateIndex->getFormBarcodeGenerate()->getFirstField()->isVisible(),
            'Field Reason is not shown'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $barcodeGenerateIndex->getFormBarcodeGenerateProduct()->getSection('os_generate_barcode')->isVisible(),
            'Section os_generate_barcode is not shown'
        );
        \PHPUnit_Framework_Assert::assertEquals('Product(s)' ,
            $barcodeGenerateIndex->getFormBarcodeGenerateProduct()->getFirstField(),
            'Field Product(s) is not shown'
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