<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 27/11/2017
 * Time: 13:52
 */
namespace Magento\BarcodeSuccess\Test\Constraint\Adminhtml\BarcodePrint\Form;


use Magento\BarcodeSuccess\Test\Page\Adminhtml\BarcodePrint\BarcodePrintIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertOpenPrintBarcodeFormIsAvailable extends AbstractConstraint
{
    public function processAssert(BarcodePrintIndex $barcodePrintIndex, $section, $firstField)
    {
    	$barcodePrintIndex->getFormBarcodePrintIndex()->waitPageToLoad();
        \PHPUnit_Framework_Assert::assertTrue(
            $barcodePrintIndex->getFormBarcodePrint()->getSection($section)->isVisible(),
            'Section '.$section.' is not shown'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $barcodePrintIndex->getFormBarcodePrint()->getFirstField($firstField)->isVisible(),
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