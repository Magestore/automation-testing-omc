<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 27/11/2017
 * Time: 20:56
 */
namespace Magento\BarcodeSuccess\Test\Constraint\Adminhtml\BarcodeTemplate\Form;
use Magento\BarcodeSuccess\Test\Page\Adminhtml\BarcodeTemplate\BarcodeViewTemplateIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertViewTemplateBarcodeFormIsAvailable extends AbstractConstraint
{
    public function processAssert(BarcodeViewTemplateIndex $barcodeViewTemplateIndex, $section, $fields)
    {
        $barcodeViewTemplateIndex->getTemplateGrid()->waitingForLoadingMaskNotVisible();
        \PHPUnit_Framework_Assert::assertTrue(
            $barcodeViewTemplateIndex->getBlockViewTemplate()->getSection($section)->isVisible(),
            'Section '.$section.' is not shown'
        );
        $nameFields = explode(', ', $fields);
        foreach($nameFields as $field)
        \PHPUnit_Framework_Assert::assertTrue(
            $barcodeViewTemplateIndex->getBlockViewTemplate()->getField($field)->isVisible(),
            'Field '.$field.' is not shown'
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