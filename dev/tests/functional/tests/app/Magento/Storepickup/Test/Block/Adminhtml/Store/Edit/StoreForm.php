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

/**
 * Class StoreForm
 * @package Magento\Storepickup\Test\Block\Adminhtml\Store\Edit
 */
class StoreForm extends FormTabs
{
    /**
     * @var string
     */
    protected $generalTitle = './/span[text()="General Information"]';

    /**
     * @var string
     */
    protected $storeNameField = '[data-ui-id="store-edit-tab-schedule-fieldset-element-form-field-store-name"]';

    /**
     * @return mixed
     */

    protected $generalInformation = [
        'Store Name' => '[name="store_name"]',
        'Description' => '[name="description"]',
        'Status' => '[name="status"]',
        "Store's Link" => '[name="link"]',
        'Sort Order' => '[name="sort_order"]',
        'Phone Number' => '[name="phone"]',
        'Email Address' => '[name="email"]',
        'Fax Number' => '[name="fax"]',
        "Owner's name" => '[name="owner_name"]',
        "Owner' Email" => '[name="owner_email"]',
        "Owner' Phone" => '[name="owner_phone"]',
        'URL Key' => '[name="rewrite_request_path"]',
        'Meta Title' => '[name="meta_title"]',
        'Meta Keywords' => '[name="meta_keywords"]',
        'Meta Description' => '[name="meta_description"]'
    ];

    protected $googleMap = [
        'Address' => '[name="address"]',
        'City' => '[name="city"]',
        'Zip Code' => '[name="zipcode"]',
        'Country' => '[name="country_id"]',
        'State/Province' => '[name="state"]',
        'Latitude' => '[name="latitude"]',
        'Longitude' => '[name="longitude"]',
        'Zoom Level' => '[name="zoom_level"]',
        'Marker Icon' => '[name="marker_icon"]',
        'Google map' => '.map-container'
    ];

    protected $imageGalery = '[id="store_gallery-container"]';

    public function generalTitleIsVisible()
    {
        return $this->_rootElement->find($this->generalTitle, Locator::SELECTOR_XPATH)->isVisible();
    }

    public function contactTitleIsVisible()
    {
        return $this->_rootElement->find('.//span[text()="Contact Information"]', Locator::SELECTOR_XPATH)->isVisible();
    }

    public function ownerInformationTitleIsVisible()
    {
        return $this->_rootElement->find('.//span[text()="Owner Information"]', Locator::SELECTOR_XPATH)->isVisible();
    }

    public function metaInformationTitleIsVisible()
    {
        return $this->_rootElement->find('.//span[text()="Meta Information"]', Locator::SELECTOR_XPATH)->isVisible();
    }

    public function locationInformationTitleIsVisible()
    {
        return $this->_rootElement->find('.//span[text()="Location Information"]', Locator::SELECTOR_XPATH)->isVisible();
    }

    public function imageGaleryTitleIsVisible()
    {
        return $this->_rootElement->find('.//span[text()="Image Gallery"]', Locator::SELECTOR_XPATH)->isVisible();
    }

    public function timeScheduleTitleIsVisible()
    {
        return $this->_rootElement->find('.//span[text()="Time Schedule"]', Locator::SELECTOR_XPATH)->isVisible();
    }

    public function imageGaleryFieldIsVisible()
    {
        return $this->_rootElement->find($this->imageGalery)->isVisible();
    }

    public function scheduleFieldIsVisible()
    {
        return $this->_rootElement->find('[name="schedule_id"]')->isVisible();
    }
    /**
     * @param $selector
     * @return mixed
     */
    public function fieldIsVisible($selector)
    {
        return $this->_rootElement->find($selector)->isVisible();
    }

    /**
     * @return mixed
     */
    public function storeNameRequireErrorIsVisible()
    {
        return $this->_rootElement->find('#store_store_name-error')->isVisible();
    }

    /**
     * @return mixed
     */
    public function addressRequireErrorIsVisible()
    {
        return $this->_rootElement->find('#store_address-error')->isVisible();
    }

    /**
     * @return mixed
     */
    public function cityRequireErrorIsVisible()
    {
        return $this->_rootElement->find('#store_city-error')->isVisible();
    }

    /**
     * @return mixed
     */
    public function zipcodeRequireErrorIsVisible()
    {
        return $this->_rootElement->find('#store_zipcode-error')->isVisible();
    }

    /**
     * @return array
     */
    public function getGeneralInformationFields()
    {
        return $this->generalInformation;
    }

    /**
     * @return array
     */
    public function getGoogleMapFields()
    {
        return $this->googleMap;
    }

    public function waitOpenTagTab()
    {
        $spinner = './/*[@id="store_tabs_tag_section"]/span/span/span[@class="spinner"]';
        $this->waitForElementNotVisible($spinner, Locator::SELECTOR_XPATH);
    }

    public function waitOpenHolidayTab()
    {
        $spinner = './/*[@id="store_tabs_holiday_section"]/span/span/span[@class="spinner"]';
        $this->waitForElementNotVisible($spinner, Locator::SELECTOR_XPATH);
    }

    public function waitOpenSpecialTab()
    {
        $spinner = './/*[@id="store_tabs_specialday_section"]/span/span/span[@class="spinner"]';
        $this->waitForElementNotVisible($spinner, Locator::SELECTOR_XPATH);
    }

    public function waitOpenOrderTab()
    {
        $spinner = './/*[@id="store_tabs_serialized_orders"]/span/span/span[@class="spinner"]';
        $this->waitForElementNotVisible($spinner, Locator::SELECTOR_XPATH);
    }
}