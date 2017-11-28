<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 28/11/2017
 * Time: 09:07
 */

namespace Magento\BarcodeSuccess\Test\Block\Adminhtml;
use Magento\Mtf\Block\Block;

class SearchScanBarcodeBlock extends Block
{
    protected   $idForm = '#config-edit-form';
    protected $firstFieldForm = 'barcodesuccess_general_one_barcode_per_sku';
    public function isVisibleForm()
    {
        return $this->_rootElement->find($this->idForm)->isVisible();
    }
    public function isFirstFieldFormVisible()
    {
        return $this->_rootElement->find($this->firstFieldForm)->isVisible();
    }
    public function getNameConfigurationBarcode(){
        return $this->_rootElement->find('#system_config_tabs > div.config-nav-block.admin__page-nav._collapsed._show > ul > li.admin__page-nav-item.item.separator-top._active > a')->getText();
    }

}