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

/**
 * Class EarningRatesForm
 * @package Magento\Rewardpoints\Test\Block\Adminhtml\EarningRates\Edit
 */
class EarningRatesForm extends FormTabs
{
    /**
     * @var string
     */
    protected $formTitle = './/span[text()="Earning Rate Information"]';

    /**
     * @var string
     */
    protected $moneySpentField = '[data-index="money"]';

    /**
     * @return mixed
     */
    protected $errorField = '.admin__field-error';

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
    public function moneySpentFieldIsVisible()
    {
        return $this->_rootElement->find($this->moneySpentField, Locator::SELECTOR_CSS)->isVisible();
    }

    /**
     * @return mixed
     */
    public function fieldErrorIsVisible(){
        return $this->_rootElement->find($this->errorField, Locator::SELECTOR_CSS)->isVisible();
    }
}