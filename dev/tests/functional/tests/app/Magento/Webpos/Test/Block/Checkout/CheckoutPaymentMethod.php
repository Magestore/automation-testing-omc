<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 04/12/2017
 * Time: 10:10
 */

namespace Magento\Webpos\Test\Block\Checkout;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

/**
 * Class CheckoutPaymentMethod
 * @package Magento\Webpos\Test\Block\CategoryRepository
 */
class CheckoutPaymentMethod extends Block
{
    public function waitForCashInMethod()
    {
        $cashInMethod = $this->_rootElement->find('.icon-iconPOS-payment-cashforpos');
        if (!$cashInMethod->isVisible()) {
            $browser = $this->_rootElement;
            $browser->waitUntil(
                function () use ($cashInMethod) {
                    $cashInMethod->isVisible();
                }
            );
        }
    }

    public function waitForCustomPayment1Method()
    {
        $customPayment1Method = $this->_rootElement->find('.icon-iconPOS-payment-cp1forpos');
        if (!$customPayment1Method->isVisible()) {
            $browser = $this->_rootElement;
            $browser->waitUntil(
                function () use ($customPayment1Method) {
                    return $customPayment1Method->isVisible() ? true : null;
                }
            );
        }
    }

    public function getCashInMethod()
    {
        $this->waitForElementVisible('.icon-iconPOS-payment-cashforpos');
        return $this->_rootElement->find('.icon-iconPOS-payment-cashforpos');
    }

    public function getTitlePaymentMethod()
    {
        return $this->_rootElement->find('label[data-bind="text: title"]');
    }

    public function getCashInMethodWhileHaveALotOfPaymentMethod()
    {
        return $this->_rootElement->find('#payment_list .icon-iconPOS-payment-cashforpos');
    }

    public function getCashOnDeliveryMethod()
    {
        return $this->_rootElement->find('.icon-iconPOS-payment-codforpos');
    }

    public function getCreditCard()
    {
        return $this->_rootElement->find('.icon-iconPOS-payment-ccforpos');
    }

    public function getCustomPayment1()
    {
        return $this->_rootElement->find('.icon-iconPOS-payment-cp1forpos');
    }

    public function getCustomPayment2()
    {
        return $this->_rootElement->find('.icon-iconPOS-payment-cp2forpos');
    }

    public function getAmountPayment()
    {
        return $this->_rootElement->find('.//*[@id="payment_selected"]//input[@onclick="this.select()"]', Locator::SELECTOR_XPATH);
    }

    public function getIconRemove()
    {
        return $this->_rootElement->find('.icon-iconPOS-remove');
    }

    public function getPaymentMethodByLabel($label)
    {
        return $this->_rootElement->find('//*[@id="payment_list"]/div/div/div/label[text()="' . $label . '"]/..', Locator::SELECTOR_XPATH);
    }

    public function getPaymentSelectedItem($label)
    {
        return $this->_rootElement->find('//*[@id="payment_selected"]/div/div/div/div[1]/label[text()="' . $label . '"]/../..', Locator::SELECTOR_XPATH);
    }

    public function getPaymentSelectedItemAmountInput($label)
    {
        return $this->getPaymentSelectedItem($label)->find('.input-actions .input-box input');
    }
}