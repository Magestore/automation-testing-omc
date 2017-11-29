<?php

namespace Magento\BarcodeSuccess\Test\Block;

use Magento\Mtf\Block\Block;

/**
 * Class PageActions
 * Abstract page actions block for Form page & Grid page action blocks to extend
 *
 */
class ManageBarcodes extends Block
{
    /**
     * "click Generate" button
     *
     * @var string
     */
    protected $generateButton = '#generate';

    /**
     * "click import" button
     *
     * @var string
     */
    protected $importButton = '#import';

    public function generateBarcode()
    {
        $this->_rootElement->find($this->generateButton)->click();
    }

    public function importBarcode()
    {
        $this->_rootElement->find($this->importButton)->click();
    }
}
