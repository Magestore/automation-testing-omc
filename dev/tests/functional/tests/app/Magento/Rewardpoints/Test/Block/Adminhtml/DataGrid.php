<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/24/2017
 * Time: 3:40 PM
 */

namespace Magento\Rewardpoints\Test\Block\Adminhtml;

use Magento\Backend\Test\Block\Widget\Grid;
use Magento\Mtf\Client\Locator;

class DataGrid extends Grid
{
    protected $col = './/th[span = "%s"]';

    protected $gridTable = '.data-grid';

    protected $loadingMask = '.admin__data-grid-loading-mask';

    public function columnIsVisible($column)
    {
        return $this->_rootElement->find(sprintf($this->col, $column), Locator::SELECTOR_XPATH)->isVisible();
    }

    public function waitingForGridVisible()
    {
        $this->waitLoader();
        $this->waitForElementNotVisible($this->loadingMask, Locator::SELECTOR_CSS);
        $this->waitForElementVisible($this->gridTable, Locator::SELECTOR_CSS);
    }
}