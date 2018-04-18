<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 27/11/2017
 * Time: 14:19
 */

namespace Magento\BarcodeSuccess\Test\Block\Adminhtml\BarcodeScan;
use Magento\Mtf\Block\Block;

class SearchScanBarcode extends Block
{
    public function inputIsVisible($idInput)
    {
        $idInput = '#'.$idInput;
        return $this->_rootElement->find($idInput)->isVisible();
    }
}