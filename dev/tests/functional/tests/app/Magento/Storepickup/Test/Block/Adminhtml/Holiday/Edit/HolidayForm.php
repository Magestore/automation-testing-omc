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

    public function dateStartFieldIsVisible()
    {
        return $this->_rootElement->find('[name="date_from"]')->isVisible();
    }

    public function dateEndFieldIsVisible()
    {
        return $this->_rootElement->find('[name="date_to"]')->isVisible();
    }

    public function commentFieldIsVisible()
    {
        return $this->_rootElement->find('[name="holiday_comment"]')->isVisible();
    }

    public function storesGridIsVisible()
    {
        return $this->_rootElement->find('[id="storepickupadmin_store_grid"]')->isVisible();
    }

    public function waitOpenStoresTab()
    {
        $spinner = './/*[@id="general_tabs_stores_section"]/span/span/span[@class="spinner"]';
        $this->waitForElementNotVisible($spinner, Locator::SELECTOR_XPATH);
    }

    public function holidayNameFieldRequireErrorIsVisible()
    {
        return $this->_rootElement->find('[id="holiday_holiday_name-error"]')->isVisible();
    }

    public function dateStartFieldRequireErrorIsVisible()
    {
        return $this->_rootElement->find('[id="holiday_date_from-error"]')->isVisible();
    }

    public function dateEndFieldRequireErrorIsVisible()
    {
        return $this->_rootElement->find('[id="holiday_date_to-error"]')->isVisible();
    }
}