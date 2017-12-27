<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 05/12/2017
 * Time: 14:07
 */

namespace Magento\BarcodeSuccess\Test\Constraint\Adminhtml\BarcodeListing\Form;

use Magento\BarcodeSuccess\Test\Page\Adminhtml\BarcodeListing\BarcodeGenerateIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Check that success message is displayed after widget saved
 */
class AssertGenerateErrorSaveMessage extends AbstractConstraint
{
    /* tags */
    const SEVERITY = 'low';
    /* end tags */
    const SUCCESS_MESSAGE = 'You must select the product to generate the barcode';

    /**
     *
     * @param BarcodeGenerateIndex
     * @return void
     */
    public function processAssert(BarcodeGenerateIndex $barcodeGenerateIndex)
    {
        $actualMessage = $barcodeGenerateIndex->getMessagesBlock()->getErrorMessage();
        \PHPUnit_Framework_Assert::assertEquals(
            self::SUCCESS_MESSAGE,
            $actualMessage,
            'Wrong success message is displayed.'
        );

    }

    /**
     * Text of Required field message assert
     *
     * @return string
     */
    public function toString()
    {
        return 'True.';
    }
}
