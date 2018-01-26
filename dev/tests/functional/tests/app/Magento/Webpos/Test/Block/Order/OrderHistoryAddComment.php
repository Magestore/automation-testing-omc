<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 07/12/2017
 * Time: 13:33
 */

namespace Magento\Webpos\Test\Block\Order;

use Magento\Mtf\Block\Block;
/**
 * Class OrderHistoryAddComment
 * @package Magento\Webpos\Test\Block\Order
 */
class OrderHistoryAddComment extends Block
{
    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getCancelButton()
    {
        return $this->_rootElement->find('#add-comment-order > div > div > form > div > button.close');
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getSaveButton()
    {
        return $this->_rootElement->find('#add-comment-order > div > div > form > div > button.btn-save.link-cl-cfg');
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getInputComment()
    {
        return $this->_rootElement->find('#input-add-comment-order');
    }
}