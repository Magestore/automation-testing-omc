<?php

namespace Magento\BarcodeSuccess\Test\Block\Adminhtml\BarcodeTemplate;

use Magento\Mtf\Block\Block;

/**
 * Class PageActions
 * Abstract page actions block for Form page & Grid page action blocks to extend
 *
 */
class AddNewTemplate extends Block
{
    /**
     * "Add New" button
     *
     * @var string
     */
    public function addNewTemplate($addNewButton)
    {
        $addNewButton = '#'.$addNewButton;
        $this->_rootElement->find($addNewButton)->click();
    }
}
