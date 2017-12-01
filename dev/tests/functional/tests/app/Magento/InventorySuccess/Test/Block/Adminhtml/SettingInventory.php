<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 28/11/2017
 * Time: 09:07
 */

namespace Magento\InventorySuccess\Test\Block\Adminhtml;
use Magento\Mtf\Block\Block;

class SettingInventory extends Block
{
    protected   $idForm = '#config-edit-form';
    protected $firstFieldForm = '#inventorysuccess_stock_control_link_warehouse_store_view';
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

	public function getStockControlSection()
	{
		return $this->_rootElement->find('#inventorysuccess_stock_control');
	}

	public function openStockControlSection()
	{
		$this->_rootElement->find('#inventorysuccess_stock_control-head')->click();
	}

}