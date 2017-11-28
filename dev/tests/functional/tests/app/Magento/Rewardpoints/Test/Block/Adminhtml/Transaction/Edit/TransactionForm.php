<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 11/28/2017
 * Time: 7:52 AM
 */
namespace Magento\Rewardpoints\Test\Block\Adminhtml\Transaction\Edit;

use Magento\Backend\Test\Block\Widget\FormTabs;
use Magento\Mtf\Client\Locator;

class TransactionForm extends FormTabs
{
    protected $formTitle = './/span[text()="Transaction Information"]';

    protected $customerField = '[data-ui-id="admin-block-rewardpoints-form-container-form-fieldset-element-form-field-featured-customers"]';

    public function formTitleIsVisible()
    {
        return $this->_rootElement->find($this->formTitle, Locator::SELECTOR_XPATH)->isVisible();
    }

    public function customerFieldIsVisible()
    {
        return $this->_rootElement->find($this->customerField, Locator::SELECTOR_CSS)->isVisible();
    }
}