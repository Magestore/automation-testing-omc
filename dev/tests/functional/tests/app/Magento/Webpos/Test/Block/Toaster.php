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

    public function waitUntilWarningMessageChange($message)
    {
        $warningMessage = $this->_rootElement->find('.message');
        $browser = $this->_rootElement;
        $browser->waitUntil(
            function () use ($warningMessage, $message) {
                return $warningMessage->getText()===$message ? true : null;
            }
        );
    }

    public function waitWarningMessage()
    {
        $warningMessage = $this->_rootElement->find('.message');
        if (!$warningMessage->isVisible()) {
            $this->waitForElementVisible('.message');
        }
    }
    public function getWarningMessage()
    {
        $this->waitWarningMessage();
        return $this->_rootElement->find('.message');
    }

    public function isWarningMessage()
    {
        return $this->_rootElement->find('.alert alert-warning alert-dismissible')->isVisible();
    }
    public function waitWarningMessageShow()
    {
        $message = $this->_rootElement->find('.message');
        if (!$message->isVisible()) {
            $this->waitForElementVisible('.message');
        }
    }
    public function waitWarningMessageHide()
    {
        $message = $this->_rootElement->find('.message');
        if ($message->isVisible()) {
            $this->waitForElementNotVisible('.message');
        }
    }
}