<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 1/31/2018
 * Time: 4:36 PM
 */

namespace Magento\Webpos\Test\Block\Adminhtml\Order;

class ShipmentHistory extends \Magento\Mtf\Block\Block
{
    public function getNoteListComment()
    {
        return $this->_rootElement->find('.note-list-comment')->getText();
    }

    public function getTrackNumber()
    {
        return $this->browser->find('tbody tr td[class="col-number"]')->getText();
    }
}