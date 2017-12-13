<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 05/12/2017
 * Time: 17:22
 */

namespace Magento\Webpos\Test\Block\Checkout;

use Magento\Mtf\Block\Block;

/**
 * Class CheckoutNoteOrder
 * @package Magento\AssertWebposCheckGUICustomerPriceCP54\Test\Block\Checkout
 */
class CheckoutNoteOrder extends Block
{
    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getPopUpOrderNoteClose()
    {
        return $this->_rootElement->find('.popup-header');
    }

    public function getCloseOrderNoteButton()
    {
        return $this->_rootElement->find('.close');
    }

    public function getSaveOrderNoteButon()
    {
        return $this->_rootElement->find('button.btn-save');
    }

    public function getTextArea()
    {
        return $this->_rootElement->find('.form-control');
    }
}