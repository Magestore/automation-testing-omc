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

    public function tagNameRequireErrorIsVisible()
    {
        return $this->_rootElement->find('#tag_tag_name-error')->isVisible();
    }
}