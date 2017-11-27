<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/27/2017
 * Time: 2:58 PM
 */

namespace Magento\Storepickup\Test\Block\Adminhtml\Holiday\Edit;

use Magento\Backend\Test\Block\Widget\FormTabs;
use Magento\Mtf\Client\Locator;

class HolidayForm extends FormTabs
{
    protected $generalTitle = './/span[text()="General Information"]';

    protected $holidayNameField = '[data-ui-id="holiday-edit-tab-general-fieldset-element-form-field-holiday-name"]';

    public function generalTitleIsVisible()
    {
        return $this->_rootElement->find($this->generalTitle, Locator::SELECTOR_XPATH)->isVisible();
    }

    public function holidayNameFieldIsVisible()
    {
        return $this->_rootElement->find($this->holidayNameField, Locator::SELECTOR_CSS)->isVisible();
    }
}