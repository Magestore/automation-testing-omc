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

/**
 * Class FormPageActions
 * @package Magento\PurchaseOrderSuccess\Test\Block\Adminhtml\Quotation
 */
class FormPageActions extends ParentFormPageActions
{
    /**
     * "Save" button.
     *
     * @var string
     */
    protected $saveButton = '#start';

    /**
     * "Confirm Quotation" button.
     *
     * @var string
     */
    protected $confirmButton = '#confirm';

    /**
     * "Confirm Quotation" button.
     *
     * @var string
     */
    protected $prepareButton = '[data-ui-id="start-button"]';

    /**
     * Click "Prepare Product List" action
     *
     * @return void
     */
    public function prepareProductList()
    {
        $this->_rootElement->find($this->prepareButton, Locator::SELECTOR_CSS)->click();
    }

    /**
     * Click "Confirm" button.
     */
    public function confirm()
    {
        $this->waitForElementVisible($this->confirmButton);
        $this->_rootElement->find($this->confirmButton)->click();
        $this->waitForElementNotVisible($this->spinner);
        $this->waitForElementNotVisible($this->loader, Locator::SELECTOR_XPATH);
        $this->waitForElementNotVisible($this->loaderOld, Locator::SELECTOR_XPATH);
    }
}