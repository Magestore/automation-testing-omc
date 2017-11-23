<?php

namespace Magento\BarcodeSuccess\Test\Block;

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
    protected $addNewButton = '#new';
    public function addNewTemplate()
    {
        $this->_rootElement->find($this->addNewButton)->click();
    }
}
