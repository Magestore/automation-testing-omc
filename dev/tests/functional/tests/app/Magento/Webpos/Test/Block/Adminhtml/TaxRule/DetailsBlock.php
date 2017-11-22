<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 06/11/2017
 * Time: 10:29
 */

namespace Magento\Webpos\Test\Block\Adminhtml\TaxRule;


use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

class DetailsBlock extends Block
{
	public function clickAdditionalSetting()
	{
		$this->_rootElement->find('#details-summarybase_fieldset')->click();
	}
	public function getProductTaxClassItem($name)
	{
		return $this->_rootElement->find('//*[@id="details-contentbase_fieldset"]/div[2]/div/section/div[1]/div/div/label/span[text()="'.$name.'"]/../..', Locator::SELECTOR_XPATH);
	}

	public function getProductTaxClassEditButton($name)
	{
		return $this->getProductTaxClassItem($name)->find('.mselect-edit');
	}

//	public function getProductTaxClassItemForm($name)
//	{
//		return $this->_rootElement->find('//*[@id="details-contentbase_fieldset"]/div[2]/div/section/div[1]/div/div/label/span/form/input[@value="'.$name.'"]/..', Locator::SELECTOR_XPATH);
//	}
//
//	public function getProductTaxClassInput($name)
//	{
//		return $this->getProductTaxClassItemForm($name)->find('input[type="text"]');
//	}
//
//
//	public function getProductTaxClassSaveButton($name)
//	{
//		return $this->getProductTaxClassItemForm($name)->find('button.mselect-save');
//	}
}