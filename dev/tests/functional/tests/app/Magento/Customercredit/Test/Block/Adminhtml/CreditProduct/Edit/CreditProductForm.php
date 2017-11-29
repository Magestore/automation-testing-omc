<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Customercredit\Test\Block\Adminhtml\CreditProduct\Edit;

use Magento\Catalog\Test\Block\Adminhtml\Product\ProductForm;

class CreditProductForm extends ProductForm
{
    protected $selectStoreCreditType = '[name="product[storecredit_type]"]';

    public function storeCreditTypeIsVisible()
    {
       return $this->_rootElement->find($this->selectStoreCreditType)->isVisible();
    }
}
