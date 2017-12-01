<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 27/11/2017
 * Time: 21:01
 */
namespace Magento\BarcodeSuccess\Test\TestCase\Adminhtml;
use Magento\BarcodeSuccess\Test\Page\Adminhtml\BarcodeViewTemplateIndex;
use Magento\Mtf\TestCase\Injectable;

class ViewNewTemplateEntityForBarcodeTest extends Injectable
{
    /* tags */
    const MVP = 'no';
    const DOMAIN = 'PS';
    /* end tags */

    /**
     * @var BarcodeViewTemplateIndex $barcodeViewTemplateIndex
     */
    protected $barcodeViewTemplateIndex;

    public function __inject(
        BarcodeViewTemplateIndex $barcodeViewTemplateIndex
    ) {
        $this->barcodeViewTemplateIndex = $barcodeViewTemplateIndex;
    }
    public function test()
    {
        $this->barcodeViewTemplateIndex->open();
    }
}