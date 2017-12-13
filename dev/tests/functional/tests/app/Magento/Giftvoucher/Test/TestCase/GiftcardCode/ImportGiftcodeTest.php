<?php
/**
 * Copyright © 2017 Magestore. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Giftvoucher\Test\TestCase\GiftcardCode;

use Magento\Giftvoucher\Test\Page\Adminhtml\GiftcodeIndex;
use Magento\Giftvoucher\Test\Page\Adminhtml\GiftcodeImport;
use Magento\Mtf\TestCase\Injectable;

class ImportGiftcodeTest extends Injectable
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
        $csvFile = 'import_giftcode_sample.csv';

        // MGC048
        $this->giftcodeIndex->open();
        $this->giftcodeIndex->getGridPageActions()->import();
        $form = $this->giftcodeImport->getImportForm();
        \PHPUnit_Framework_Assert::assertTrue($form->isVisible());

        // MGC049
        $form->downloadSample($csvFile);
        \PHPUnit_Framework_Assert::assertFileExists($csvFile);

        // MGC050
        $form->fillCsvFormFile($csvFile);
        $this->giftcodeImport->getMainActions()->back();
        \PHPUnit_Framework_Assert::assertTrue($this->giftcodeIndex->getGiftcodeGroupGrid()->isVisible());

        // MGC051
        $this->giftcodeImport->open();
        $form->fillCsvFormFile($csvFile);
        $this->giftcodeImport->getMainActions()->save();

        // Remove file
        unlink($csvFile);
    }
}
