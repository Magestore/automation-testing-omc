<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 3/8/2018
 * Time: 4:58 PM
 */

namespace Magento\Webpos\Test\Block\SessionManagement;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

/**
 * Class SessionConfirmModalPopup
 * @package Magento\Webpos\Test\Block\SessionManagement
 */
class SessionConfirmModalPopup extends Block
{
    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getModalTitle()
    {
        return $this->_rootElement->find('#modal-title-4');
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getCancelButton()
    {
        return $this->_rootElement->find('.action-dismiss');
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getOkButton()
    {
        return $this->_rootElement->find('.action-accept');
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getCloseButton()
    {
        return $this->_rootElement->find('.action-close');
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getContent()
    {
        return $this->_rootElement->find('.modal-content');
    }

    /**
     * @return mixed
     */
    public function getRealBalance()
    {
//        $text = $this->getContent()->getText();
        $text = $this->_rootElement->find('.modal-content div')->getText();
        preg_match_all('/\d+\.\d+/', $text, $matches);
        return $matches[0][0];
    }

    /**
     * @return mixed
     */
    public function getTheoryIs()
    {
        $text = $this->getContent()->getText();
        preg_match_all('/\d+\.\d+/', $text, $matches);
        return $matches[0][1];
    }

    /**
     * @return mixed
     */
    public function getLoss()
    {
        $text = $this->getContent()->getText();
        preg_match_all('/\d+\.\d+/', $text, $matches);
        return $matches[0][2];
    }
}