<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 25/09/2017
 * Time: 16:27
 */

namespace Magento\Webpos\Test\Block;


use Magento\Mtf\Block\Block;

class Modal extends Block
{
    public function getModalPopup()
    {
        return $this->_rootElement->find('.modal-popup');
    }

    public function waitForModalPopup()
    {
        $this->waitForElementVisible('.modal-popup');
        sleep(1);
    }

    public function waitForModalPopupNotVisible()
    {
        $this->waitForElementNotVisible('.modal-popup');
    }

    public function getPopupMessage()
    {
        return $this->getPopupMessageElement()->getText();
    }

    public function getPopupMessageElement()
    {
        return $this->_rootElement->find('aside > div.modal-inner-wrap > div > div');
    }

    public function getCancelButton()
    {
        return $this->_rootElement->find('aside > div.modal-inner-wrap > footer > button.action-secondary.action-dismiss');
    }

    public function waitForCancelButtonIsVisible()
    {
        return $this->waitForElementVisible('aside > div.modal-inner-wrap > footer > button.action-secondary.action-dismiss');
    }

    public function getOkButton()
    {
        return $this->_rootElement->find('.action-accept');
    }

    public function waitForOkButtonIsVisible()
    {
        return $this->waitForElementVisible('.action-accept');
    }

    public function getCloseButton()
    {
        return $this->_rootElement->find('.action-close');
    }

    public function waitForCloseButtonIsVisible()
    {
        return $this->waitForElementVisible('.action-close');
    }

    public function waitForLoadingIndicator()
    {
        $this->waitForElementNotVisible('.indicator');
    }

    public function waitForLoader()
    {
        $this->waitForElementVisible('.modal-popup');
    }

    public function getElementById($id)
    {
        $this->_rootElement->find('#' . $id);
    }
}