<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 12/27/2017
 * Time: 9:10 AM
 */

namespace Magento\PurchaseOrderSuccess\Test\Block\Adminhtml\Quotation;

use Magento\Backend\Test\Block\FormPageActions as ParentFormPageActions;
use Magento\Mtf\Client\Locator;
use Magento\Mtf\Fixture\FixtureInterface;

class FormPageActions extends ParentFormPageActions
{
    protected $prepareButton = '[data-ui-id="start-button"]';
    /**
     * Click save and new action
     *
     * @return void
     */
    public function prepareProductList()
    {
        $this->_rootElement->find($this->prepareButton, Locator::SELECTOR_CSS)->click();
    }
}