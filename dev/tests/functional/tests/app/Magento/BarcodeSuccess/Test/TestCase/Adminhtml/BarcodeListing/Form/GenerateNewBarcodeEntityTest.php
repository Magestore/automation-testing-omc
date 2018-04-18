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
use Magento\BarcodeSuccess\Test\Fixture\BarcodeGenerate;
/**
 *
 * Steps:
 * 1. Open backend
 * 2. Go to  page BarcodeGenerate
 * 3. Perform Asserts for Form
 *
 */
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

    /**
     * @param BarcodeGenerate $barcodeGenerate
     */
    public function test(BarcodeGenerate $barcodeGenerate, $fields = null, $tag)
    {
        $this->barcodeGenerateIndex->open();
        $this->barcodeGenerateIndex->getBarcodeGrid()->waitingForLoadingMaskFormNotVisible();
        if($tag == '0')
        {
            $this->barcodeGenerateIndex->getPageActionsBlock()->save();
            return ['of_products' => '0'];
        }
        $products = $barcodeGenerate->getProducts();
        if ($products != null) {
            $this->barcodeGenerateIndex->getFormBarcodeGenerate()->clickSelectProducts();
            $this->barcodeGenerateIndex->getProductsBlock()->setFieldsData($products);
        }
        if($fields != null)
            $this->barcodeGenerateIndex->getFormBarcodeGenerate()->getSection('os_barcode_generate_form_general')->setFieldsData($fields);
        $this->barcodeGenerateIndex->getPageActionsBlock()->save();
        return ['of_products' => count($products)];
    }
}