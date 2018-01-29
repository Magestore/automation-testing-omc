<?php

namespace Magento\BarcodeSuccess\Test\TestCase\Adminhtml\BarcodeTemplate;
use Magento\BarcodeSuccess\Test\Page\Adminhtml\BarcodeTemplate\BarcodeTemplateIndex;
use Magento\Mtf\TestCase\Injectable;
/**
 *
 * Steps:
 * 1. Open backend
 * 2. Go to  page BarcodeTemplate
 * 3. Click button ("Add New Template")
 * 4. Perform Asserts
 *
 */
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
        $this->barcodeTemplateIndex->getTemplateGrid()->waitingForLoadingMaskNotVisible();
        $this->barcodeTemplateIndex->getAddNewTemplate()->addNewTemplate($addNewButton);
        $this->barcodeTemplateIndex->getTemplateGrid()->waitingForLoadingMaskNotVisible();
        $this->barcodeTemplateIndex->getTemplateGrid()->waitingForLoadingMaskFormNotVisible();
    }
}