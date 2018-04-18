<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/28/2017
 * Time: 1:40 PM
 */

namespace Magento\PurchaseOrderSuccess\Test\Block\Adminhtml\Pricelist\Modal\PriceList;

use Magento\Backend\Test\Block\FormPageActions;

class PriceListFormAction extends FormPageActions
{
    protected $addProduct = 'button[class="action-primary"]';

    public function addSelectedProducts()
    {
        $this->_rootElement->find($this->addProduct)->click();
    }
}