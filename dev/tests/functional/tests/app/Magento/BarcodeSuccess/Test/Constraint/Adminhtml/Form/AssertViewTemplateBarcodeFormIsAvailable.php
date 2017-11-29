<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 27/11/2017
 * Time: 20:56
 */
namespace Magento\BarcodeSuccess\Test\Constraint\Adminhtml\Form;


use Magento\BarcodeSuccess\Test\Page\Adminhtml\BarcodeViewTemplateIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertViewTemplateBarcodeFormIsAvailable extends AbstractConstraint
{
    public function processAssert(BarcodeViewTemplateIndex $barcodeViewTemplateIndex)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $barcodeViewTemplateIndex->getBlockViewTemplate()->getSection('barcode_template_information')->isVisible(),
            'Section barcode_template_information is not shown'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $barcodeViewTemplateIndex->getBlockViewTemplate()->getFirstField()->isVisible(),
            'Field  Select Barcode Label Format is not shown'
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