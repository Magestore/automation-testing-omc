<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Giftvoucher\Test\Block\Onepage;

use Magento\Mtf\Block\Block;
use Magento\Payment\Test\Fixture\CreditCard;
use Magento\Checkout\Test\Block\Onepage\Payment as CheckoutPayment;
/**
 * CategoryRepository payment block.
 */
class Payment extends CheckoutPayment
{
    /**
     * Get selected payment method block.
     *
     * @return \Magento\Giftvoucher\Test\Block\Onepage\Payment\Method
     */
    public function getSelectedPaymentMethodBlock()
    {
        $element = $this->_rootElement->find($this->activePaymentMethodSelector);

        return $this->blockFactory->create(
            \Magento\Giftvoucher\Test\Block\Onepage\Payment\Method::class,
            ['element' => $element]
        );
    }
}
