<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 24/11/2017
 * Time: 10:45
 */

namespace Magento\BarcodeSuccess\Test\Block\Adminhtml;


use Magento\Backend\Test\Block\GridPageActions;
use Magento\Mtf\Client\Locator;

class GridPageActionsBlock extends GridPageActions
{
	protected $buttonSelector = '//button[@id="%s"]';
	public function buttonIsVisible($id)
	{
		return $this->_rootElement->find(sprintf($this->buttonSelector, $id), Locator::SELECTOR_XPATH)->isVisible();
	}
}