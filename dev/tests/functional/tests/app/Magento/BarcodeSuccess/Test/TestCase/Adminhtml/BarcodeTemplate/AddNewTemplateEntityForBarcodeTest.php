<?php

namespace Magento\BarcodeSuccess\Test\TestCase\Adminhtml\BarcodeTemplate;
use Magento\BarcodeSuccess\Test\Page\Adminhtml\BarcodeTemplate\BarcodeTemplateIndex;
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
    public function test($addNewButton)
    {
        $this->barcodeTemplateIndex->open();
        $this->barcodeTemplateIndex->getBarcodeGrid()->waitingForLoadingMaskNotVisible();
        $this->barcodeTemplateIndex->getAddNewTemplate()->addNewTemplate($addNewButton);
    }
}