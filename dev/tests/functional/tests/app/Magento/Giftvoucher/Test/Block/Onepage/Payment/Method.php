<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Giftvoucher\Test\Block\Onepage\Payment;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;
use Magento\Checkout\Test\Block\Onepage\Payment\Method as CheckoutMethod;
/**
 * Checkout payment method block.
 */
class Method extends CheckoutMethod
{
    /**
     * Get "Billing Address" block.
     *
     * @return \Magento\Giftvoucher\Test\Block\Onepage\Payment\Method\Billing
     */
    public function getBillingBlock()
    {
        $element = $this->_rootElement->find($this->billingAddressSelector);

        return $this->blockFactory->create(
            \Magento\Giftvoucher\Test\Block\Onepage\Payment\Method\Billing::class,
            ['element' => $element]
        );
    }
}
