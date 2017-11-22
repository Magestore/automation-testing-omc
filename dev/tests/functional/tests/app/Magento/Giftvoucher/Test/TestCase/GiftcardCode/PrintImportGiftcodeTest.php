<?php
/**
 * Copyright © 2017 Magestore. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Giftvoucher\Test\TestCase\GiftcardCode;

use Magento\Giftvoucher\Test\Page\Adminhtml\GiftcodeIndex;
use Magento\Giftvoucher\Test\Page\Adminhtml\GiftcodeImport;
use Magento\Mtf\TestCase\Injectable;

class PrintImportGiftcodeTest extends Injectable
{
    /**
     * @var GiftcodeIndex
     */
    protected $giftcodeIndex;

    /**
     * @var GiftcodeImport
     */
    protected $giftcodeImport;

    public function __inject(
        GiftcodeIndex $giftcodeIndex,
        GiftcodeImport $giftcodeImport
    ) {
        $this->giftcodeIndex = $giftcodeIndex;
        $this->giftcodeImport = $giftcodeImport;
    }

    /**
     * Test import
     *
     * @param array $data
     * @param string $fixtureType
     * @return array
     */
    public function test()
    {
        $csvFile = 'giftvoucher.csv';

        $this->giftcodeImport->open();
        $form = $this->giftcodeImport->getImportForm();
        $form->downloadSample($csvFile);

        // MGC052
        $form->fillCsvFormFile($csvFile);
        $this->giftcodeImport->getMainActions()->clickPrint();

        // Remove file
        unlink($csvFile);
    }
}
