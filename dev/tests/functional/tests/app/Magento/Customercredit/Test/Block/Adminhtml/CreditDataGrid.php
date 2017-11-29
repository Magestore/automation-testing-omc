<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/24/2017
 * Time: 2:51 PM
 */

namespace Magento\Customercredit\Test\Block\Adminhtml;

use Magento\Mtf\Client\Locator;
use Magento\Ui\Test\Block\Adminhtml\DataGrid;

class CreditDataGrid extends DataGrid
{
    protected $col = './/th[span = "%s"]';

    protected $gridTable = '.data-grid';

    protected $loadingMask = '.admin__data-grid-loading-mask';

    protected $gridMassactionForm = '.admin__grid-massaction-form';

    protected $exportData = '.admin__data-grid-export';

    protected $pager = '.admin__data-grid-pager-wrap';

    protected $dataGridFilters = './/thead/tr[@class="data-grid-filters"]';

    public function columnIsVisible($column)
    {
        return $this->_rootElement->find(sprintf($this->col, $column), Locator::SELECTOR_XPATH)->isVisible();
    }

    public function waitingForGridVisible()
    {
//        $this->waitLoader();
        $this->waitForElementNotVisible($this->loadingMask, Locator::SELECTOR_CSS);
        $this->waitForElementVisible($this->gridTable, Locator::SELECTOR_CSS);
    }

    public function searchButtonIsVisible()
    {
        return $this->_rootElement->find($this->searchButton, Locator::SELECTOR_CSS)->isVisible();
    }

    public function resetButtonIsVisible()
    {
        return $this->_rootElement->find($this->resetButton, Locator::SELECTOR_CSS)->isVisible();
    }

    public function gridMassactionFormIsVisible()
    {
        return $this->_rootElement->find($this->gridMassactionForm, Locator::SELECTOR_CSS)->isVisible();
    }

    public function exportDataGridIsVisible()
    {
        return $this->_rootElement->find($this->exportData, Locator::SELECTOR_CSS)->isVisible();
    }

    public function dataGridPagerIsVisible()
    {
        return $this->_rootElement->find($this->pager, Locator::SELECTOR_CSS)->isVisible();
    }

    public function dataGridFiltersIsVisible()
    {
        return $this->_rootElement->find($this->dataGridFilters, Locator::SELECTOR_XPATH)->isVisible();
    }

}