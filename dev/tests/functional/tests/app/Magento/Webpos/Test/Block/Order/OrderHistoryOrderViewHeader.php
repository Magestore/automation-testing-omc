<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 07/12/2017
 * Time: 13:30
 */

namespace Magento\Webpos\Test\Block\Order;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

/**
 * Class OrderHistoryOrderViewHeader
 * @package Magento\Webpos\Test\Block\Order
 */
class OrderHistoryOrderViewHeader extends Block
{
    public function getOrderId()
    {
        return $this->_rootElement->find('div.id-order > label > span')->getText();
    }

    public function getStatus()
    {
        return $this->_rootElement->find('.status')->getText();
    }

    public function openAddOrderNote()
    {
        $this->_rootElement->find('.more-info')->click();
    }

    // More info - Actions box
    public function getMoreInfoButton()
    {
        return $this->_rootElement->find('nav > div.more-info > a');
    }

    public function getAction($text)
    {
        return $this->_rootElement->find('//*[@id="form-add-note-order"]/ul/li/a[text()="' . $text . '"]', Locator::SELECTOR_XPATH);
    }

    public function waitForClosedStatusVisisble()
    {
        return $this->waitForElementVisible('.status.closed');
    }

    public function waitForProcessingStatusVisisble()
    {
        return $this->waitForElementVisible('.status.processing');
    }

    public function waitForPendingStatusVisisble()
    {
        return $this->waitForElementVisible('.status.pending');
    }

    public function waitForCompleteStatusVisisble()
    {
        return $this->waitForElementVisible('.status.complete');
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getTakePaymentButton()
    {
        return $this->_rootElement->find('.take-payment');
    }

    public function titleOrderIdIsVisible()
    {
        return $this->_rootElement->find('[class="title-header-page"]')->isVisible();
    }

    public function getGrandTotal()
    {
        return $this->_rootElement->find('.//span[@class="price"]', Locator::SELECTOR_XPATH)->getText();
    }
}