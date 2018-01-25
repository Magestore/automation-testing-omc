<?php
/**
 * Created by PhpStorm.
 * User: bang
 * Date: 12/01/2018
 * Time: 09:56
 */
namespace Magento\Webpos\Test\Block\Order;
use Magento\Mtf\Block\Block;
/**
 * Class OrderHistoryAddComment
 * @package Magento\Webpos\Test\Block\Order
 */
class OrderHistoryBlockForBackend extends Block
{
    public function getComment(){
        return $this->_rootElement->find('.note-list-comment')->getText();
    }
}