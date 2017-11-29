<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 28/11/2017
 * Time: 10:30
 */
namespace Magento\PurchaseOrderSuccess\Test\Block\Adminhtml\Settings;
use Magento\Mtf\Block\Block;

class SettingSupplierConfiguration extends Block
{
    protected   $idForm = '#config-edit-form';
    protected $firstFieldForm = '#suppliersuccess_pricelist_enable';
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