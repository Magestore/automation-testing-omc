<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 07/12/2017
 * Time: 09:06
 */
namespace Magento\BarcodeSuccess\Test\TestCase\Adminhtml\BarcodeListing\Form;
use Magento\Mtf\TestCase\Injectable;
use Magento\BarcodeSuccess\Test\Page\Adminhtml\BarcodeListing\BarcodeGenerateIndex;

class GenerateNewBarcodeEntityTest extends Injectable
{
    /* tags */
    const MVP = 'no';
    const DOMAIN = 'PS';
    /* end tags */

    /**
     * @var BarcodeGenerateIndex
     */
    protected $barcodeGenerateIndex;

    public function __inject(
        BarcodeGenerateIndex $barcodeGenerateIndex
    ) {
        $this->barcodeGenerateIndex = $barcodeGenerateIndex;
    }
    public function test(array $products = null, $fields = null)
    {
        $this->barcodeGenerateIndex->open();
        $this->barcodeGenerateIndex->getBarcodeGrid()->waitingForLoadingMaskFormNotVisible();
        if($fields != null)
            $this->barcodeGenerateIndex->getFormBarcodeGenerate()->getSection('os_barcode_generate_form_general')->setFieldsData($fields);
        if($products != null){
            $this->barcodeGenerateIndex->getFormBarcodeGenerate()->getSection('os_generate_barcode')->setFieldsData($products);
        }
        $this->barcodeGenerateIndex->getPageActionsBlock()->save();

    }
}