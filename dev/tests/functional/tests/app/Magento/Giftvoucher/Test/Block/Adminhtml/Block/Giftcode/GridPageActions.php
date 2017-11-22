<?php

namespace Magento\Giftvoucher\Test\Block\Adminhtml\Block\Giftcode;

/**
 * Class GridPageActions
 */
class GridPageActions extends \Magento\Backend\Test\Block\GridPageActions
{
    /**
     * "Import Gift Codes" button
     *
     * @var string
     */
    protected $importButton = '#import';

    /**
     * Click "Import Gift Codes" button
     */
    public function import()
    {
        $this->_rootElement->find($this->importButton)->click();
    }
}
