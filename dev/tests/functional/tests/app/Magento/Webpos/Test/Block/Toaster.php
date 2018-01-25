<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 25/09/2017
 * Time: 15:53
 */

namespace Magento\Webpos\Test\Block;

use Magento\Mtf\Block\Block;

class Toaster extends Block
{
    public function getWarningMessage()
    {
	    $this->waitForElementVisible('.message');
        return $this->_rootElement->find('.message');
    }

    public function isWarningMessage()
    {
        return $this->_rootElement->find('.alert alert-warning alert-dismissible')->isVisible();
    }
}