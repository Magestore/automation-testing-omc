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
 * @package Magento\AssertWebposCheckGUICustomerPriceCP54\Test\Block\CategoryRepository
 */
class CheckoutNoteOrder extends Block
{
    public function waitPopUpOrderNoteClose()
    {
        $popUpOrderNoteClose = $this->_rootElement->find('.popup-header');
        $browser = $this->_rootElement;
        $browser->waitUntil(
            function () use ($popUpOrderNoteClose) {
                return $popUpOrderNoteClose->isVisible() ? true : null;
            }
        );
    }
    public function getPopUpOrderNoteClose()
    {
        return $this->_rootElement->find('.popup-header');
    }

    public function waitForCloseOrderNoteButon()
    {
        $closeOrderNoteButon = $this->_rootElement->find('.close');
        if (!$closeOrderNoteButon->isVisible()) {
            $this->waitForElementVisible('.close');
        }
    }
    public function getCloseOrderNoteButton()
    {
        return $this->_rootElement->find('.close');
    }

    public function waitForSaveOrderNoteButon()
    {
        $saveOrderNoteButon = $this->_rootElement->find('button.btn-save');
        $browser = $this->_rootElement;
        $browser->waitUntil(
            function () use ($saveOrderNoteButon) {
                return $saveOrderNoteButon->isVisible() ? true : null;
            }
        );
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