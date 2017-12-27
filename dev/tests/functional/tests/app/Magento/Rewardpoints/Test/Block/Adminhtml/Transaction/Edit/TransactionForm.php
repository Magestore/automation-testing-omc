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

    /**
     * @var string
     */
    protected $selectCustomer = ".addafter";

    /**
     * @var string
     */
    protected $tableCustomer = "#tinycontentCustomer";

    /**
     * @return mixed
     */
    protected $errorField = '.mage-error';

    /**
     *
     */
    public function clickSelectCustomer(){
        $this->_rootElement->find($this->selectCustomer, Locator::SELECTOR_CSS)->click();
        $this->waitForElementVisible($this->tableCustomer);
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

    /**
     * @return mixed
     */
    public function fieldErrorIsVisible(){
        return $this->_rootElement->find($this->errorField, Locator::SELECTOR_CSS)->isVisible();
    }
}