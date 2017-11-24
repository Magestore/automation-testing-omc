<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 23/11/2017
 * Time: 14:26
 */

namespace Magento\PurchaseOrderSuccess\Test\Block;

use Magento\Mtf\Block\Block;

class ReturnRequest extends Block
{
    /**
     * "click createReturnRequest" button
     *
     * @var string
     */
    protected $buttonReturnRequest = "#add";

    public function createReturnRequest()
    {
        $this->_rootElement->find($this->buttonReturnRequest)->click();
    }

}