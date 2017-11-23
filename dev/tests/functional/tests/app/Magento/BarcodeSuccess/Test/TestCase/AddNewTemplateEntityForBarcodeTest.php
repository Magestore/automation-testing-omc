<?php

namespace Magento\BarcodeSuccess\Test\TestCase;
use Magento\BarcodeSuccess\Test\Page\Adminhtml\BarcodeTemplateIndex;
use Magento\Mtf\TestCase\Injectable;

class AddNewTemplateEntityForBarcodeTest extends Injectable
{
    /* tags */
    const MVP = 'no';
    const DOMAIN = 'PS';
    /* end tags */

    /**
     * @var BarcodeTemplateIndex $barcodeTemplateIndex
     */
    protected $barcodeTemplateIndex;

    public function __inject(
        BarcodeTemplateIndex $barcodeTemplateIndex
    ) {
        $this->barcodeTemplateIndex = $barcodeTemplateIndex;
    }
    public function test()
    {
        $this->barcodeTemplateIndex->open();
        $this->barcodeTemplateIndex->getAddNewTemplate()->addNewTemplate();
        sleep(2);
    }
}