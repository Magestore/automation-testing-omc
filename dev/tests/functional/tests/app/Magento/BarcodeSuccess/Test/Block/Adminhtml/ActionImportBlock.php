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

class ActionImportBlock extends GridPageActions
{
	public function buttonIsVisible($text)
	{
        //*[@id="save"]/span/span
	    return $this->_rootElement->find('//*[@id="save"]/span/span[text()="'.$text.'"]/..', Locator::SELECTOR_XPATH)->isVisible();
	}
}