<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 1/30/2018
 * Time: 5:38 PM
 */

namespace Magento\Webpos\Test\Block\Adminhtml\Order\Create\Shipping;

use Magento\Mtf\Client\Locator;

class Method extends \Magento\Sales\Test\Block\Adminhtml\Order\Create\Shipping\Method
{
    private $waitElement = '.loading-mask';

    public function waitFormLoading()
    {
        $this->browser->waitUntil(
            function () {
                return $this->browser->find($this->waitElement)->isVisible() ? null : true;
            }
        );
    }

    public function selectShippingMethod(array $shippingMethod)
    {
        $this->waitFormLoading();
        if ($this->_rootElement->find($this->shippingMethodsLink)->isVisible()) {
            $this->_rootElement->find($this->shippingMethodsLink)->click();
        }
        $selector = sprintf(
            $this->shippingMethod,
            $shippingMethod['shipping_service'],
            $shippingMethod['shipping_method']
        );
        $this->waitFormLoading();
        $this->_rootElement->find($selector, Locator::SELECTOR_XPATH)->click();
    }
}