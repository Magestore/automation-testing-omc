<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 12/15/2017
 * Time: 10:06 AM
 */

namespace Magento\Rewardpoints\Test\Block\Adminhtml\Transaction\Edit;

use Magento\Backend\Test\Block\Widget\FormTabs;
use Magento\Mtf\Client\Locator;
use Magento\Customer\Test\Fixture\Customer;

/**
 * Class SelectCustomerForm
 * @package Magento\Rewardpoints\Test\Block\Adminhtml\Transaction\Edit
 */
class SelectCustomerForm extends FormTabs
{
    /**
     * @var string
     */
    protected $buttonSearch = '[data-ui-id="widget-button-4"]';

    /**
     * @var string
     */
    protected $callColumSelect = '//*[@class="tbox"]//td/input[@value="%s"]';

    /**
     * @var string
     */
    protected $emailSearchField = '[data-ui-id="widget-grid-column-filter-text-3-filter-email"]';

    /**
     * @param Customer $customer
     */
    public function selectedCustomer(Customer $customer){
        $this->_rootElement->find($this->emailSearchField, Locator::SELECTOR_CSS)->setvalue($customer->getEmail());
        $this->_rootElement->find($this->buttonSearch, Locator::SELECTOR_CSS)->click();
        $this->waitForElementNotVisible('[data-role="loader"]');
        $this->_rootElement->find(sprintf($this->callColumSelect,$customer->getId()), Locator::SELECTOR_XPATH)->click();
    }

}