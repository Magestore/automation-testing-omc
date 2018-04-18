<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/1/2018
 * Time: 11:17 AM
 */

namespace Magento\Webpos\Test\Block\Adminhtml\Order\Invoice;

use Magento\Mtf\Block\Block;

class InvoiceHistory extends Block
{
    public function getNoteListComment()
    {
        return $this->_rootElement->find('.note-list-comment')->getText();
    }
}