<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\BarcodeSuccess\Test\Constraint\Adminhtml\BarcodeListing;

use Magento\BarcodeSuccess\Test\Page\Adminhtml\BarcodeListing\BarcodeHistoryIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Check that success message is displayed after widget saved
 */
class AssertBarcodeSuccessSaveMessage extends AbstractConstraint
{
    /* tags */
    const SEVERITY = 'low';
    /* end tags */

    /**
     * Text value to be checked
     */
    const SUCCESS_MESSAGE = ' barcode(s) has been generated.';

    /**
     * Assert that success message is displayed after template saved
     *
     * @param BarcodeHistoryIndex
     * @return void
     */
    public function processAssert(BarcodeHistoryIndex $barcodeHistoryIndex, $of_products)
    {
        $actualMessage = $barcodeHistoryIndex->getMessagesBlock()->getSuccessMessage();
        \PHPUnit_Framework_Assert::assertEquals(
            $of_products.self::SUCCESS_MESSAGE,
            $actualMessage,
            'Wrong success message is displayed.'
        );
    }

    /**
     * Text of Created Widget Success Message assert
     *
     * @return string
     */
    public function toString()
    {
        return 'Barcode  success generate message is present.';
    }
}
