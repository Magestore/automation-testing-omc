<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 23/11/2017
 * Time: 14:30
 */

namespace Magento\PurchaseOrderSuccess\Test\Block;

use Magento\Mtf\Block\Block;

class Pricelist extends Block
{
    /**
     * "click add Price List" button
     *
     * @var string
     */
    protected $buttonAddPriceList = "#container > div > div.entry-edit.form-inline > div > div > fieldset > div.admin__field-complex > div.admin__field-complex-elements > button:nth-child(1)";
    /**
     * "click import Price List" button
     *
     * @var string
     */
    protected $buttonImportPriceList = "#container > div > div.entry-edit.form-inline > div > div > fieldset > div.admin__field-complex > div.admin__field-complex-elements > button:nth-child(2)";

    public function createAddPriceList()
    {
        $this->_rootElement->find($this->buttonAddPriceList)->click();
    }

    public function createImportPriceList()
    {
        $this->_rootElement->find($this->buttonImportPriceList)->click();
    }
}