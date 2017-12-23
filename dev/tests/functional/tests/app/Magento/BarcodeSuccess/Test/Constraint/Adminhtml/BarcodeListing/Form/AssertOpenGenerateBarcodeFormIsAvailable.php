<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 27/11/2017
 * Time: 10:04
 */
namespace Magento\BarcodeSuccess\Test\Constraint\Adminhtml\BarcodeListing\Form;


use Magento\BarcodeSuccess\Test\Page\Adminhtml\BarcodeListing\BarcodeGenerateIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertOpenGenerateBarcodeFormIsAvailable extends AbstractConstraint
{
    public function processAssert(BarcodeGenerateIndex $barcodeGenerateIndex, $firstFieldGeneral, $sectionGeneral, $firstFieldProduct, $sectionProduct )
    {

        \PHPUnit_Framework_Assert::assertTrue(
            $barcodeGenerateIndex->getFormBarcodeGenerate()->getSection($sectionGeneral)->isVisible(),
            'Section os_barcode_generate_form_general is not shown'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $barcodeGenerateIndex->getFormBarcodeGenerate()->getFirstField($firstFieldGeneral)->isVisible(),
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
        return "General Form is available";
    }
}