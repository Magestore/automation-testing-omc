<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/24/2017
 * Time: 3:40 PM
 */

namespace Magento\Rewardpoints\Test\Block\Adminhtml;

use Magento\Mtf\Client\Locator;
use Magento\Ui\Test\Block\Adminhtml\DataGrid;

class RewardGrid extends DataGrid
{
    protected $gridTable = '.data-grid';

    protected $loadingMask = '.admin__data-grid-loading-mask';

    protected $gridSearchControl = '.data-grid-search-control-wrap';

    protected $dataGridAction = '.admin__data-grid-actions-wrap';

    protected $dataGridPager = '.admin__data-grid-pager-wrap';

    public function columnIsVisible($column)
    {
        return $this->_rootElement->find(sprintf($this->columnHeader, $column), Locator::SELECTOR_XPATH)->isVisible();
    }

    public function waitingForGridVisible()
    {
//        $this->waitLoader();
        $this->waitForElementNotVisible($this->loadingMask, Locator::SELECTOR_CSS);
        $this->waitForElementVisible($this->gridTable, Locator::SELECTOR_CSS);
    }

    public function waitingForGridNotVisible()
    {
        $this->waitForElementNotVisible($this->gridTable, Locator::SELECTOR_CSS);
    }

    public function dataGridSearchIsVisible()
    {
        return $this->_rootElement->find($this->gridSearchControl, Locator::SELECTOR_CSS)->isVisible();
    }

    public function actionButtonIsVisible()
    {
        return $this->_rootElement->find($this->actionButton, Locator::SELECTOR_CSS)->isVisible();
    }

    public function filtersButtonIsVisible()
    {
        return $this->_rootElement->find($this->filterButton, Locator::SELECTOR_CSS)->isVisible();
    }

    public function dataGridActionIsVisible()
    {
        return $this->_rootElement->find($this->dataGridAction, Locator::SELECTOR_CSS)->isVisible();
    }

    public function dataGridPagerIsVisible()
    {
        return $this->_rootElement->find($this->dataGridPager, Locator::SELECTOR_CSS)->isVisible();
    }
}