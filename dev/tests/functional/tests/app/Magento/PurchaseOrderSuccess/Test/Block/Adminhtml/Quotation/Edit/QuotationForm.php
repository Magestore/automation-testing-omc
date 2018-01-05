<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 27/11/2017
 * Time: 14:03
 */

namespace Magento\PurchaseOrderSuccess\Test\Block\Adminhtml\Quotation\Edit;


use Magento\PurchaseOrderSuccess\Test\Block\Adminhtml\FormSection;

class QuotationForm extends FormSection
{
    /**
     * @return mixed
     */
    protected $errorField = '.admin__field-error';

    /**
     * @return mixed
     */
    public function fieldErrorIsVisible(){
        return $this->_rootElement->find($this->errorField, Locator::SELECTOR_CSS)->isVisible();
    }
}