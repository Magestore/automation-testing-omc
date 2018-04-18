<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/27/2017
 * Time: 2:21 PM
 */

namespace Magento\Storepickup\Test\Block\Adminhtml\Tag\Edit;

use Magento\Backend\Test\Block\Widget\FormTabs;
use Magento\Mtf\Client\Locator;

/**
 * Class TagForm
 * @package Magento\Storepickup\Test\Block\Adminhtml\Tag\Edit
 */
class TagForm extends FormTabs
{
    /**
     * @var string
     */
    protected $generalTitle = './/span[text()="General Information"]';

    /**
     * @var string
     */
    protected $tagNameField = '[data-ui-id="tag-edit-tab-general-fieldset-element-form-field-tag-name"]';

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
    public function tagNameFieldIsVisible()
    {
        return $this->_rootElement->find($this->tagNameField, Locator::SELECTOR_CSS)->isVisible();
    }

    public function descriptionFieldIsVisible()
    {
        return $this->_rootElement->find('[name="tag_description"]')->isVisible();
    }

    public function iconFieldIsVisible()
    {
        return $this->_rootElement->find('[name="tag_icon"]')->isVisible();
    }

    public function waitOpenStoresTab()
    {
        $spinner = './/*[@id="tag_tabs_stores_section"]/span/span/span[@class="spinner"]';
        $this->waitForElementNotVisible($spinner, Locator::SELECTOR_XPATH);
    }

    public function storesGridIsVisible()
    {
        return $this->_rootElement->find('[id="storepickupadmin_store_grid"]')->isVisible();
    }

    public function tagNameRequireErrorIsVisible()
    {
        return $this->_rootElement->find('#tag_tag_name-error')->isVisible();
    }
}