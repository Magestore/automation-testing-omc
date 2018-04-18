<?php

namespace Magento\Giftvoucher\Test\Block\Adminhtml\Block\Giftcode;

/**
 * Class ImportActions
 */
class ImportActions extends \Magento\Backend\Test\Block\FormPageActions
{
    /**
     * "Print" button
     *
     * @var string
     */
    protected $printButton = '#print';

    /**
     * Click "Print" button
     */
    public function clickPrint()
    {
        $this->_rootElement->find($this->printButton)->click();
    }
}
