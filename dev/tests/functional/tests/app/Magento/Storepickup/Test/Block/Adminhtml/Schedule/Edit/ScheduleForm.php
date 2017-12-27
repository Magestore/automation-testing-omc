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

/**
 * Class ScheduleForm
 * @package Magento\Storepickup\Test\Block\Adminhtml\Schedule\Edit
 */
class ScheduleForm extends FormTabs
{
    /**
     * @var string
     */
    protected $generalTitle = './/span[text()="General Information"]';

    /**
     * @var string
     */
    protected $scheduleNameField = '[data-ui-id="schedule-edit-tab-general-fieldset-element-form-field-schedule-name"]';

    protected $scheduleTime = [
        '%s status' => '[name="%s_status"]',
        '%s open time' => [
            '[id="schedule_%s_open_hour"]',
            '[id="schedule_%s_open_minute"]'
        ],
        '%s open break time' => [
            '[id="schedule_%s_open_break_hour"]',
            '[id="schedule_%s_open_break_minute"]'
        ],
        '%s close break time' => [
            '[id="schedule_%s_close_break_hour"]',
            '[id="schedule_%s_close_break_minute"]'
        ],
        '%s close time' => [
            '[id="schedule_%s_close_hour"]',
            '[id="schedule_%s_close_minute"]'
        ]
    ];

    public function scheduleFieldIsVisible($day, $selector)
    {
         if (is_array($selector)) {
             $selector[0] = sprintf($selector[0], $day);
             $selector[1] = sprintf($selector[1], $day);
             return $this->_rootElement->find($selector[0])->isVisible()
                 && $this->_rootElement->find($selector[1])->isVisible();
         }
         $selector = sprintf($selector, $day);
         return $this->_rootElement->find($selector)->isVisible();
    }

    public function getScheduleTime()
    {
        return $this->scheduleTime;
    }

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
    public function scheduleNameFieldIsVisible()
    {
        return $this->_rootElement->find($this->scheduleNameField, Locator::SELECTOR_CSS)->isVisible();
    }

    public function scheduleNameRequireErrorIsVisible()
    {
        return $this->_rootElement->find('[id="schedule_schedule_name-error"]')->isVisible();
    }

    public function storesGridIsVisisble()
    {
        return $this->_rootElement->find('[id="storepickupadmin_store_grid"]')->isVisible();
    }

    public function waitOpenStoresTab()
    {
        $spinner = './/*[@id="schedule_tabs_stores_section"]/span/span/span[@class="spinner"]';
        $this->waitForElementNotVisible($spinner, Locator::SELECTOR_XPATH);
    }
}