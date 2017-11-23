<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 23/11/2017
 * Time: 14:16
 */
namespace Magento\PurchaseOrderSuccess\Test\Block;

use Magento\Mtf\Block\Block;

class Quotation extends Block
{
    /**
     * "click createQuotation" button
     *
     * @var string
     */
    protected $buttonCreateQuotation = "#add";

    public function createQuotationOrder()
    {
        $this->_rootElement->find($this->buttonCreateQuotation)->click();
    }

}
