<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 27/11/2017
 * Time: 13:52
 */
namespace Magento\BarcodeSuccess\Test\Constraint\Adminhtml\Form;


use Magento\BarcodeSuccess\Test\Page\Adminhtml\BarcodePrintIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertOpenPrintBarcodeFormIsAvailable extends AbstractConstraint
{
    public function processAssert(BarcodePrintIndex $barcodePrintIndex)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $barcodePrintIndex->getFormBarcodePrintIndex()->getSection('barcode_template_information')->isVisible(),
            'Section barcode_template_information is not shown'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $barcodePrintIndex->getFormBarcodePrintIndex()->getFirstField()->isVisible(),
            'Field type is not shown'
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