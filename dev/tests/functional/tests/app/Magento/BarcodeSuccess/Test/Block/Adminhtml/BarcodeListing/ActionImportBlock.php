<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 24/11/2017
 * Time: 10:45
 */

namespace Magento\BarcodeSuccess\Test\Block\Adminhtml\BarcodeListing;


use Magento\Backend\Test\Block\GridPageActions;
use Magento\Mtf\Client\Locator;

class ActionImportBlock extends GridPageActions
{
	public function buttonIsVisible($id)
	{
        $id = '#'.$id;
	    return $this->_rootElement->find($id)->isVisible();
	}
}