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

class TagForm extends FormTabs
{
    protected $generalTitle = './/span[text()="General Information"]';

    protected $tagNameField = '[data-ui-id="tag-edit-tab-general-fieldset-element-form-field-tag-name"]';

    public function generalTitleIsVisible()
    {
        return $this->_rootElement->find($this->generalTitle, Locator::SELECTOR_XPATH)->isVisible();
    }

    public function tagNameFieldIsVisible()
    {
        return $this->_rootElement->find($this->tagNameField, Locator::SELECTOR_CSS)->isVisible();
    }
}