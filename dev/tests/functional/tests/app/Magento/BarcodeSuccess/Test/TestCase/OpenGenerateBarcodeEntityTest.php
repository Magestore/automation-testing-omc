<?php

namespace Magento\BarcodeSuccess\Test\TestCase;
use Magento\Mtf\TestCase\Injectable;
use Magento\BarcodeSuccess\Test\Page\Adminhtml\BarcodeIndex;

class OpenGenerateBarcodeEntityTest extends Injectable
{
    /* tags */
    const MVP = 'no';
    const DOMAIN = 'PS';
    /* end tags */

    /**
     * @var BarcodeIndex $barcodeIndex
     */
    protected $barcodeIndex;

    public function __inject(
        BarcodeIndex $barcodeIndex
    ) {
        $this->barcodeIndex = $barcodeIndex;
    }
    public function test()
    {
        $this->barcodeIndex->open();
        $this->barcodeIndex->getManageBarcodes()->generateBarcode();
        sleep(2);
    }
}