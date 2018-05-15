<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 25/09/2017
 * Time: 15:53
 */

namespace Magento\Webpos\Test\Block;

use Magento\Mtf\Block\Block;
/**
 * Class Toaster
 * @package Magento\Webpos\Test\Block
 */
class Toaster extends Block
{
    public function waitUntilWarningMessage()
    {
        $warningMessage = $this->_rootElement->find('.message');
        $browser = $this->_rootElement;
        $browser->waitUntil(
            function () use ($warningMessage) {
                return $warningMessage->isVisible() ? true : null;
            }
        );
    }

    public function getWarningMessage()
    {
	    $this->waitForElementVisible('.message');
        return $this->_rootElement->find('.message');
    }

    public function isWarningMessage()
    {
        return $this->_rootElement->find('.alert alert-warning alert-dismissible')->isVisible();
    }
    public function waitWarningMessageHide()
    {
        $this->waitForElementVisible('.message');
    }
}