<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/27/2017
 * Time: 2:43 PM
 */

namespace Magento\Storepickup\Test\Block\Adminhtml\Schedule\Edit;

use Magento\Backend\Test\Block\Widget\FormTabs;
use Magento\Mtf\Client\Locator;

class ScheduleForm extends FormTabs
{
    protected $generalTitle = './/span[text()="General Information"]';

    protected $scheduleNameField = '[data-ui-id="schedule-edit-tab-general-fieldset-element-form-field-schedule-name"]';

    public function generalTitleIsVisible()
    {
        return $this->_rootElement->find($this->generalTitle, Locator::SELECTOR_XPATH)->isVisible();
    }

    public function scheduleNameFieldIsVisible()
    {
        return $this->_rootElement->find($this->scheduleNameField, Locator::SELECTOR_CSS)->isVisible();
    }
}