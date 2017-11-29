<?php

namespace Magento\BarcodeSuccess\Test\TestCase\Adminhtml;
use Magento\Mtf\TestCase\Injectable;
use Magento\BarcodeSuccess\Test\Page\Adminhtml\BarcodePrintIndex;

class CheckPrintSectionEntityForBarcodeTest extends Injectable
{
    /* tags */
    const MVP = 'no';
    const DOMAIN = 'PS';
    /* end tags */

    /**
     * @var BarcodePrintIndex $barcodePrintIndex
     */
    protected $barcodePrintIndex;

    public function __inject(
        BarcodePrintIndex $barcodePrintIndex
    ) {
        $this->barcodePrintIndex = $barcodePrintIndex;
    }
    public function test()
    {
        $this->barcodePrintIndex->open();
        sleep(2);
    }
}