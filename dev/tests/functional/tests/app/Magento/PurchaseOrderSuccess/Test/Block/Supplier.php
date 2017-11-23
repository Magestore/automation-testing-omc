<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 23/11/2017
 * Time: 14:29
 */

namespace Magento\PurchaseOrderSuccess\Test\Block;

use Magento\Mtf\Block\Block;

class Supplier extends Block
{
    /**
     * "click addNewSupplier" button
     *
     * @var string
     */
    protected $buttonAddNewSupplier = "#add";

    public function createAddNewSupplier()
    {
        $this->_rootElement->find($this->buttonAddNewSupplier)->click();
    }

}