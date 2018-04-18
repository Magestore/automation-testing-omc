<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 05/12/2017
 * Time: 14:07
 */

namespace Magento\BarcodeSuccess\Test\Constraint\Adminhtml\BarcodeTemplate\Form;

use Magento\BarcodeSuccess\Test\Page\Adminhtml\BarcodeTemplate\BarcodeViewTemplateIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Check that success message is displayed after widget saved
 */
class AssertTemplateErrorSaveMessage extends AbstractConstraint
{
    /* tags */
    const SEVERITY = 'low';
    /* end tags */

    /**
     *
     * @param BarcodeViewTemplateIndex $barcodeViewTemplateIndex
     * @return void
     */
    public function processAssert(BarcodeViewTemplateIndex $barcodeViewTemplateIndex, $classRequired, $fieldRequireds)
    {
        $fieldRequiredSplit = explode(', ', $fieldRequireds);
        foreach ($fieldRequiredSplit as $fieldRequired){
            \PHPUnit_Framework_Assert::assertTrue(
                $barcodeViewTemplateIndex->getBlockViewTemplate()->getMessageRequired($fieldRequired, $classRequired)->isVisible(),
                'Required '.$fieldRequired.' message is not displayed.'
            );
        }

    }

    /**
     * Text of Required field message assert
     *
     * @return string
     */
    public function toString()
    {
        return 'Required field is displayed.';
    }
}
