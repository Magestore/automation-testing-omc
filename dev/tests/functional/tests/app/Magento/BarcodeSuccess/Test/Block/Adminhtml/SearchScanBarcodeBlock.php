<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 27/11/2017
 * Time: 14:19
 */

namespace Magento\BarcodeSuccess\Test\Block\Adminhtml;
use Magento\Mtf\Block\Block;

class SearchScanBarcodeBlock extends Block
{
    public function inputIsVisible()
    {
        $input = '#os_barcode_scan';
        return $this->_rootElement->find($input)->isVisible();
    }
}