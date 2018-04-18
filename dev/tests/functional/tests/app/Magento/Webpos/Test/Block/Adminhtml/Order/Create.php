<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 1/30/2018
 * Time: 5:33 PM
 */

namespace Magento\Webpos\Test\Block\Adminhtml\Order;

use Magento\Mtf\Client\Locator;

class Create extends \Magento\Sales\Test\Block\Adminhtml\Order\Create
{
    public function getShippingMethodBlock()
    {
        return $this->blockFactory->create(
            \Magento\Webpos\Test\Block\Adminhtml\Order\Create\Shipping\Method::class,
            ['element' => $this->_rootElement->find($this->shippingMethodBlock, Locator::SELECTOR_CSS)]
        );
    }

    public function selectShippingMethod(array $shippingMethod)
    {
        $this->_rootElement->find($this->orderMethodsSelector)->click();
        $this->getShippingMethodBlock()->selectShippingMethod($shippingMethod);
        $this->getTemplateBlock()->waitLoader();
    }
}