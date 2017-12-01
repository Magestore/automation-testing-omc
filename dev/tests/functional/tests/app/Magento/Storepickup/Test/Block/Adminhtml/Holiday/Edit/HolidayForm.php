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

/**
 * Class HolidayForm
 * @package Magento\Storepickup\Test\Block\Adminhtml\Holiday\Edit
 */
class HolidayForm extends FormTabs
{
    /**
     * @var string
     */
    protected $generalTitle = './/span[text()="General Information"]';

    /**
     * @var string
     */
    protected $holidayNameField = '[data-ui-id="holiday-edit-tab-general-fieldset-element-form-field-holiday-name"]';

    /**
     * @return mixed
     */
    public function generalTitleIsVisible()
    {
        return $this->_rootElement->find($this->generalTitle, Locator::SELECTOR_XPATH)->isVisible();
    }

    /**
     * @return mixed
     */
    public function holidayNameFieldIsVisible()
    {
        return $this->_rootElement->find($this->holidayNameField, Locator::SELECTOR_CSS)->isVisible();
    }
}