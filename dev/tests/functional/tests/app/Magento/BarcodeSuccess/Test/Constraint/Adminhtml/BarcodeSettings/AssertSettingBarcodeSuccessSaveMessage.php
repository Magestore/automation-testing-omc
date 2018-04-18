<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\BarcodeSuccess\Test\Constraint\Adminhtml\BarcodeSettings;

use Magento\BarcodeSuccess\Test\Page\Adminhtml\BarcodeSettings\BarcodeSettingsIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Check that success message is displayed after widget saved
 */
class AssertSettingBarcodeSuccessSaveMessage extends AbstractConstraint
{
    /* tags */
    const SEVERITY = 'low';
    /* end tags */

    /**
     * Text value to be checked
     */
    const SUCCESS_MESSAGE = 'You saved the configuration.';

    /**
     * Assert that success message is displayed after config barcode saved
     *
     * @param BarcodeSettingsIndex
     * @return void
     */
    public function processAssert(BarcodeSettingsIndex $barcodeSettingsIndex)
    {
        $actualMessage = $barcodeSettingsIndex->getMessagesBlock()->getSuccessMessage();
        \PHPUnit_Framework_Assert::assertEquals(
            self::SUCCESS_MESSAGE,
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
        return 'Configu barcode success create message is present.';
    }
}
