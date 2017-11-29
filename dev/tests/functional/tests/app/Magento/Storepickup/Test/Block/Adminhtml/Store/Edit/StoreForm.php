<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/27/2017
 * Time: 9:23 AM
 */

namespace Magento\Storepickup\Test\Block\Adminhtml\Store\Edit;

use Magento\Backend\Test\Block\Widget\FormTabs;
use Magento\Mtf\Client\Locator;

class StoreForm extends FormTabs
{
    protected $generalTitle = './/span[text()="General Information"]';

    protected $storeNameField = '[data-ui-id="store-edit-tab-schedule-fieldset-element-form-field-store-name"]';

    public function generalTitleIsVisible()
    {
        return $this->_rootElement->find($this->generalTitle, Locator::SELECTOR_XPATH)->isVisible();
    }

    public function storeNameFieldIsVisible()
    {
        return $this->_rootElement->find($this->storeNameField, Locator::SELECTOR_CSS)->isVisible();
    }
}