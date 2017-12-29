<?php

/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 12/28/2017
 * Time: 10:39 AM
 */

namespace Magento\PurchaseOrderSuccess\Test\Block\Adminhtml\ReturnOrder;


use Magento\Backend\Test\Block\FormPageActions;
use Magento\Mtf\Client\Locator;


class ReturnOrderFormPageActions extends FormPageActions
{
    protected $save = "#start";
    public function save()
    {
        $this->waitForElementVisible($this->save);
        $this->_rootElement->find($this->save)->click();
//        $this->waitForElementNotVisible($this->spinner);
//        $this->waitForElementNotVisible($this->loader, Locator::SELECTOR_XPATH);
//        $this->waitForElementNotVisible($this->loaderOld, Locator::SELECTOR_XPATH);
    }
}