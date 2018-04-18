<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Giftvoucher\Test\Block\Onepage\Payment\Method;

use Magento\Customer\Test\Fixture\Address;
use Magento\Mtf\Block\Form;
use Magento\Mtf\Client\Locator;
use Magento\Checkout\Test\Block\Onepage\Payment\Method\Billing as CheckoutBilling;
/**
 * One page checkout status billing block.
 */
class Billing extends CheckoutBilling
{
    public function clickEdit()
    {
        $edit = $this->_rootElement->find('.action.action-edit-address');
        if ($edit->isVisible()) {
            $this->_rootElement->find('.action.action-edit-address')->click();
        }
    }

    /**
     * Unset "Same as shipping" checkbox value.
     *
     * @return void
     */
    public function unsetSameAsShippingCheckboxValue()
    {
        $this->_rootElement->find($this->sameAsShippingCheckbox, Locator::SELECTOR_CSS, 'checkbox')->setValue('No');
    }
}
