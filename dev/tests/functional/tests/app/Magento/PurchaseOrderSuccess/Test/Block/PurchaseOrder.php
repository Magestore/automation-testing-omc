<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 23/11/2017
 * Time: 13:55
 */
namespace Magento\PurchaseOrderSuccess\Test\Block;

use Magento\Mtf\Block\Block;

class PurchaseOrder extends Block
{
    /**
     * "click createPurchaseOrder" button
     *
     * @var string
     */
    protected $buttonCreatePurchaseOrder = "#add";

    public function createPurchaseOrder()
    {
        $this->_rootElement->find($this->buttonCreatePurchaseOrder)->click();
    }

}
