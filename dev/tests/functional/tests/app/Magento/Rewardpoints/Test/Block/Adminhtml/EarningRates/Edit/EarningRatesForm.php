<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 11/28/2017
 * Time: 7:52 AM
 */
namespace Magento\Rewardpoints\Test\Block\Adminhtml\EarningRates\Edit;

use Magento\Backend\Test\Block\Widget\FormTabs;
use Magento\Mtf\Client\Locator;

class EarningRatesForm extends FormTabs
{
    protected $formTitle = './/span[text()="Earning Rate Information"]';

    protected $moneySpentField = '[data-index="money"]';

    public function formTitleIsVisible()
    {
        return $this->_rootElement->find($this->formTitle, Locator::SELECTOR_XPATH)->isVisible();
    }

    public function moneySpentFieldIsVisible()
    {
        return $this->_rootElement->find($this->moneySpentField, Locator::SELECTOR_CSS)->isVisible();
    }
}