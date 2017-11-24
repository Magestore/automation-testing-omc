<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 24/11/2017
 * Time: 10:45
 */

namespace Magento\InventorySuccess\Test\Block\Adminhtml;


use Magento\Backend\Test\Block\GridPageActions;
use Magento\Mtf\Client\Locator;

class GridPageActionsBlock extends GridPageActions
{
	public function buttonIsVisible($text)
	{
		return $this->_rootElement->find('//div[2]/div/div/button/span[text()="'.$text.'"]/..', Locator::SELECTOR_XPATH)->isVisible();
	}
}