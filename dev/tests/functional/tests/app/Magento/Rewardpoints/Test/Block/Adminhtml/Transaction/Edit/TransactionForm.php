<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 11/28/2017
 * Time: 7:52 AM
 */
namespace Magento\Rewardpoints\Test\Block\Adminhtml\Transaction\Edit;

use Magento\Backend\Test\Block\Widget\FormTabs;
use Magento\Mtf\Client\Locator;
use Magento\Customer\Test\Fixture\Customer;


/**
 * Class TransactionForm
 * @package Magento\Rewardpoints\Test\Block\Adminhtml\Transaction\Edit
 */
class TransactionForm extends FormTabs
{
    /**
     * @var string
     */
    protected $formTitle = './/span[text()="Transaction Information"]';

    /**
     * @var string
     */
    protected $customerField = '[data-ui-id="admin-block-rewardpoints-form-container-form-fieldset-element-form-field-featured-customers"]';

    protected $selectCustomer = ".addafter";
    protected $tableCustomer = "#tinycontentCustomer";
    protected $buttonSearch = '[data-ui-id="widget-button-4"]';
    protected $callColumSelect = './/input[@value,"%s"]';
    protected $idSearchField = '[data-ui-id="widget-grid-column-filter-text-3-filter-email"]';


    public function selectedCustomer(Customer $customer){
        $this->_rootElement->find($this->selectCustomer, Locator::SELECTOR_CSS)->click();
        $this->waitForElementVisible($this->tableCustomer);

        $this->_rootElement->find($this->idSearchField, Locator::SELECTOR_CSS)->setvalue($customer->getEmail());
        $this->_rootElement->find($this->buttonSearch, Locator::SELECTOR_CSS)->click();
        $this->_rootElement->find(sprintf($this->callColumSelect,$customer->getId()), Locator::SELECTOR_XPATH)->click();
    }

    /**
     * @return mixed
     */
    public function formTitleIsVisible()
    {
        return $this->_rootElement->find($this->formTitle, Locator::SELECTOR_XPATH)->isVisible();
    }

    /**
     * @return mixed
     */
    public function customerFieldIsVisible()
    {
        return $this->_rootElement->find($this->customerField, Locator::SELECTOR_CSS)->isVisible();
    }
}