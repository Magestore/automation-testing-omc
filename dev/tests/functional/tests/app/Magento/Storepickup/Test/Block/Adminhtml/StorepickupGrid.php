<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/24/2017
 * Time: 3:40 PM
 */

namespace Magento\Storepickup\Test\Block\Adminhtml;

use Magento\Backend\Test\Block\Widget\Grid;
use Magento\Mtf\Client\Locator;
use Magento\Ui\Test\Block\Adminhtml\DataGrid;

/**
 * Class StorepickupGrid
 * @package Magento\Storepickup\Test\Block\Adminhtml
 */
class StorepickupGrid extends DataGrid
{
    /**
     * @var string
     */
    protected $gridTable = '.data-grid';

    /**
     * @var string
     */
    protected $loadingMask = '.admin__data-grid-loading-mask';

    /**
     * @var string
     */
    protected $gridSearchControl = '.data-grid-search-control-wrap';

    /**
     * @var string
     */
    protected $dataGridAction = '.admin__data-grid-actions-wrap';

    /**
     * @var string
     */
    protected $dataGridPager = '.admin__data-grid-pager-wrap';

    /**
     * @param $column
     * @return mixed
     */
    public function columnIsVisible($column)
    {
        return $this->_rootElement->find(sprintf($this->columnHeader, $column), Locator::SELECTOR_XPATH)->isVisible();
    }

    /**
     *
     */
    public function waitingForGridVisible()
    {
//        $this->waitLoader();
        $this->waitForElementNotVisible($this->loadingMask, Locator::SELECTOR_CSS);
        $this->waitForElementVisible($this->gridTable, Locator::SELECTOR_CSS);
    }

    /**
     *
     */
    public function waitingForGridNotVisible()
    {
        $this->waitForElementNotVisible($this->gridTable, Locator::SELECTOR_CSS);
    }

    /**
     * @return mixed
     */
    public function dataGridSearchIsVisible()
    {
        return $this->_rootElement->find($this->gridSearchControl, Locator::SELECTOR_CSS)->isVisible();
    }

    /**
     * @return mixed
     */
    public function actionButtonIsVisible()
    {
        return $this->_rootElement->find($this->actionButton, Locator::SELECTOR_CSS)->isVisible();
    }

    /**
     * @return mixed
     */
    public function filtersButtonIsVisible()
    {
        return $this->_rootElement->find($this->filterButton, Locator::SELECTOR_CSS)->isVisible();
    }

    /**
     * @return mixed
     */
    public function dataGridActionIsVisible()
    {
        return $this->_rootElement->find($this->dataGridAction, Locator::SELECTOR_CSS)->isVisible();
    }

    /**
     * @return mixed
     */
    public function dataGridPagerIsVisible()
    {
        return $this->_rootElement->find($this->dataGridPager, Locator::SELECTOR_CSS)->isVisible();
    }
}