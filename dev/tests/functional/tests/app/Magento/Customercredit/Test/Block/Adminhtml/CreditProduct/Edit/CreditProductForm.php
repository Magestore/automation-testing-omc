<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Customercredit\Test\Block\Adminhtml\CreditProduct\Edit;

use Magento\Catalog\Test\Block\Adminhtml\Product\ProductForm;

/**
 * Class CreditProductForm
 * @package Magento\Customercredit\Test\Block\Adminhtml\CreditProduct\Edit
 */
class CreditProductForm extends ProductForm
{
    /**
     * @var string
     */
    protected $selectStoreCreditType = '[name="product[storecredit_type]"]';

    /**
     * @return bool
     */
    public function storeCreditTypeIsVisible()
    {
       return $this->_rootElement->find($this->selectStoreCreditType)->isVisible();
    }
}
