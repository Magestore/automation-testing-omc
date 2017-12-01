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
    public function generalTitleIsVisible()
    {
        return $this->_rootElement->find($this->generalTitle, Locator::SELECTOR_XPATH)->isVisible();
    }

    /**
     * @return mixed
     */
    public function storeNameFieldIsVisible()
    {
        return $this->_rootElement->find($this->storeNameField, Locator::SELECTOR_CSS)->isVisible();
    }
}