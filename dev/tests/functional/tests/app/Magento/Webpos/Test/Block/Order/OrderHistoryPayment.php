<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 07/12/2017
 * Time: 13:31
 */

namespace Magento\Webpos\Test\Block\Order;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

/**
 * Class OrderHistoryPayment
 * @package Magento\Webpos\Test\Block\Order
 */
class OrderHistoryPayment extends Block
{
    /**
     * @param $label
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getPaymentMethod($label){
       return $this->_rootElement->find('//*[@id="order_payment_list_container"]/div/div[1]/div/div/label[text()="'.$label.'"]/..',Locator::SELECTOR_XPATH);
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getPaymentPriceInput(){
        return $this->_rootElement->find('//*[@id="payment_selected"]/div/div/div/div[3]/div/input',Locator::SELECTOR_XPATH);
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getSubmitButton()
    {
        return $this->_rootElement->find('#payment_popup_form > div.modal-body > div.action > button.btn-cl-cfg-active');
    }
}