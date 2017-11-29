<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 23/11/2017
 * Time: 16:36
 */
namespace Magento\PurchaseOrderSuccess\Test\Block\Adminhtml\Pricelist;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

class ModalImportPricelist extends Block
{
	protected $mainActionsButtonSelector = '//*[@id="html-body"]/div[6]/aside[1]/div[2]/header/div/div/div/button[span = "%s"]';

	public function getTitle()
	{
		return $this->_rootElement->find('div.modal-inner-wrap > header > h1')->getText();
	}

	public function getCancelButton()
	{
		$text = 'Cancel';
//		return $this->_rootElement->find(sprintf($this->mainActionsButtonSelector, $text), Locator::SELECTOR_XPATH);
		return $this->_rootElement->find('#html-body > div.modals-wrapper > aside.modal-slide.mage-new-video-dialog.form-inline._show > div.modal-inner-wrap > header > div > div > div > button:nth-child(1)');
	}

	public function getImportButton()
	{
		$text = 'Import';
//		return $this->_rootElement->find(sprintf($this->mainActionsButtonSelector, $text), Locator::SELECTOR_XPATH);
		return $this->_rootElement->find('#html-body > div.modals-wrapper > aside.modal-slide.mage-new-video-dialog.form-inline._show > div.modal-inner-wrap > header > div > div > div > button.action-primary');

	}

	public function getChooseFileButton()
	{
		return $this->_rootElement->find('#import_product_file');
	}
}