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

/**
 * Class SpecialdayForm
 * @package Magento\Storepickup\Test\Block\Adminhtml\Specialday\Edit
 */
class SpecialdayForm extends FormTabs
{
    /**
     * @var string
     */
    protected $generalTitle = './/span[text()="General Information"]';

    /**
     * @var string
     */
    protected $specialDayNameField = '[name="specialday_name"]';

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
    public function specialDayNameFieldIsVisible()
    {
        return $this->_rootElement->find($this->specialDayNameField, Locator::SELECTOR_CSS)->isVisible();
    }

    public function dateStartFieldIsVisible()
    {
        return $this->_rootElement->find('[name="date_from"]')->isVisible();
    }

    public function dateEndFieldIsVisible()
    {
        return $this->_rootElement->find('[name="date_to"]')->isVisible();
    }

    public function openTimeFieldIsVisible()
    {
        return $this->_rootElement->find('[id="specialday_time_open_hour"]')->isVisible()
            && $this->_rootElement->find('[id="specialday_time_open_minute"]')->isVisible();
    }

    public function closeTimeFieldIsVisible()
    {
        return $this->_rootElement->find('[id="specialday_time_close_hour"]')->isVisible()
            && $this->_rootElement->find('[id="specialday_time_close_minute"]')->isVisible();
    }

    public function commentFieldIsVisible()
    {
        return $this->_rootElement->find('[name="specialday_comment"]')->isVisible();
    }

    public function specialdayNameFieldRequireErrorIsVisible()
    {
        return $this->_rootElement->find('[id="specialday_specialday_name-error"]')->isVisible();
    }

    public function dateStartFieldRequireErrorIsVisible()
    {
        return $this->_rootElement->find('[id="specialday_date_from-error"]')->isVisible();
    }

    public function dateEndFieldRequireErrorIsVisible()
    {
        return $this->_rootElement->find('[id="specialday_date_to-error"]')->isVisible();
    }

    public function waitOpenStoresTab()
    {
        $spinner = './/*[@id="specialday_tabs_stores_section"]/span/span/span[@class="spinner"]';
        $this->waitForElementNotVisible($spinner, Locator::SELECTOR_XPATH);
    }
    public function storesGridIsVisible()
    {
        return $this->_rootElement->find('[id="storepickupadmin_store_grid"]')->isVisible();
    }
}