<?php

namespace Magento\Giftvoucher\Test\Block;

use Magento\Mtf\Block\Block;

class PrintBlock extends Block
{
    /**
     * Gift code print item selector
     *
     * @var string
     */
    protected $printItem = '.giftcode-print-page';

    /**
     * Count number of gift codes were printed
     *
     * @return number
     */
    public function getCountGiftcodes()
    {
        return count($this->_rootElement->getElements($this->printItem));
    }
}
