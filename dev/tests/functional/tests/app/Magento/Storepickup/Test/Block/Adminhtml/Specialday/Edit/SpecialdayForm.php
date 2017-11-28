<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/27/2017
 * Time: 3:13 PM
 */

namespace Magento\Storepickup\Test\Block\Adminhtml\Specialday\Edit;

use Magento\Backend\Test\Block\Widget\FormTabs;
use Magento\Mtf\Client\Locator;

class SpecialdayForm extends FormTabs
{
    protected $generalTitle = './/span[text()="General Information"]';

    protected $specialDayNameField = '[data-ui-id="specialday-edit-tab-general-fieldset-element-form-field-specialday-name"]';

    public function generalTitleIsVisible()
    {
        return $this->_rootElement->find($this->generalTitle, Locator::SELECTOR_XPATH)->isVisible();
    }

    public function specialDayNameFieldIsVisible()
    {
        return $this->_rootElement->find($this->specialDayNameField, Locator::SELECTOR_CSS)->isVisible();
    }
}