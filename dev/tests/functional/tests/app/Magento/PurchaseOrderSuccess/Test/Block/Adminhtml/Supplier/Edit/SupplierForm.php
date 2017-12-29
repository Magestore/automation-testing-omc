<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 27/11/2017
 * Time: 14:29
 */

namespace Magento\PurchaseOrderSuccess\Test\Block\Adminhtml\Supplier\Edit;


use Magento\Mtf\Client\Locator;
use Magento\PurchaseOrderSuccess\Test\Block\Adminhtml\FormSection;

class SupplierForm extends FormSection
{
    protected $requireError = './/*[@data-index="%s"]//label[@class="admin__field-error"]';

    public function requireFieldErrorsIsVisible($field)
    {
        $errorMsg = sprintf($this->requireError, $field);
        return $this->_rootElement->find($errorMsg, Locator::SELECTOR_XPATH)->isVisible();
    }

    public function fieldIsVisible($selector)
    {
        return $this->_rootElement->find($selector)->isVisible();
    }
}