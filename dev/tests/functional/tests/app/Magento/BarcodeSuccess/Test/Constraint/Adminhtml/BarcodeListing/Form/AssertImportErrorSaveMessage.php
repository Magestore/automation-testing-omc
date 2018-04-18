<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 05/12/2017
 * Time: 14:07
 */

namespace Magento\BarcodeSuccess\Test\Constraint\Adminhtml\BarcodeListing\Form;

use Magento\BarcodeSuccess\Test\Page\Adminhtml\BarcodeListing\BarcodeImportIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Check that success message is displayed after widget saved
 */
class AssertImportErrorSaveMessage extends AbstractConstraint
{
    /* tags */
    const SEVERITY = 'low';
    /* end tags */

    /**
     *
     * @param BarcodeImportIndex
     * @return void
     */
    public function processAssert(BarcodeImportIndex $barcodeImportIndex, $idRequireds)
    {
        $idfieldRequireds = explode(', ', $idRequireds);
        foreach ($idfieldRequireds as $idfieldRequired){
            \PHPUnit_Framework_Assert::assertTrue(
                $barcodeImportIndex->getFormBarcodeImport()->getField($idfieldRequired)->isVisible(),
                'Required '.$idfieldRequired.' message is not displayed.'
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
