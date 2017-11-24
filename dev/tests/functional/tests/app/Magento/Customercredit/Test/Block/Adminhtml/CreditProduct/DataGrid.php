<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/23/2017
 * Time: 11:07 PM
 */

namespace Magento\Customercredit\Test\Block\Adminhtml\CreditProduct;

use Magento\Backend\Test\Block\Widget\Grid;
use Magento\Mtf\Client\Locator;

class DataGrid extends Grid
{
    protected $col = './/th[span = "%s"]';

    protected $loadingMask = '.admin__data-grid-loading-mask';
    public function columnIsVisible($column)
    {
        return $this->_rootElement->find(sprintf($this->col, $column), Locator::SELECTOR_XPATH)->isVisible();
    }

    public function waitingForGridVisible()
    {
        $this->waitForElementNotVisible($this->loadingMask, Locator::SELECTOR_CSS);
    }
}