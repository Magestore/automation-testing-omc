<?php

namespace Magento\BarcodeSuccess\Test\Block\Adminhtml\BarcodeListing;

use Magento\Mtf\Block\Block;

/**
 * Class PageActions
 * Abstract page actions block for Form page & Grid page action blocks to extend
 *
 */
class ManageBarcodes extends Block
{

    public function clickButton($id)
    {
        $this->_rootElement->find($id)->click();
    }

}
