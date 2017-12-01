<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 23/11/2017
 * Time: 16:30
 */

namespace Magento\PurchaseOrderSuccess\Test\Block\Adminhtml\Pricelist;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

class ModalAddPricelist extends Block
{
	protected $mainActionsButtonSelector = '//aside[contains(@class, "os_supplier_pricinglist_form_os_supplier_pricinglist_form_supplier_pricinglist_listing_add")]/div[2]/header/div/div/div/button[span = "%s"]';

	public function getTitle()
	{
		return $this->_rootElement->find('div.modal-inner-wrap > header > h1')->getText();
	}

	public function getCancelButton()
	{
		$text = 'Cancel';
		return $this->_rootElement->find(sprintf($this->mainActionsButtonSelector, $text), Locator::SELECTOR_XPATH);
	}

	public function getAddSelectedProductsButton()
	{
		$text = 'Add selected product(s)';
		return $this->_rootElement->find(sprintf($this->mainActionsButtonSelector, $text), Locator::SELECTOR_XPATH);
	}

	public function getSupplierSelect()
	{
		return $this->_rootElement->find('select[name="supplier_id"]');
	}

	public function getSelectProductButton()
	{
		return $this->_rootElement->find('button[data-index="select_product_button"]');
	}
}