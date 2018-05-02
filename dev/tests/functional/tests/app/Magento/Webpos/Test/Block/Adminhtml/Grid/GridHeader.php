<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 02/05/2018
 * Time: 15:24
 */

namespace Magento\Webpos\Test\Block\Adminhtml\Grid;

use Magento\Mtf\Client\Locator;
use Magento\Ui\Test\Block\Adminhtml\DataGrid;

/**
 * Class GridHeader
 * @package Magento\Webpos\Test\Block\Adminhtml\Grid
 */
class GridHeader extends DataGrid
{
    protected $selectAction = '.action-select';

    protected $actionNameElement = './/div[@class="action-menu-items"]/ul[@class="action-menu"]/li/span[contains(text(), "%s")]';

    /**
     * Locator value for "Filter" button.
     *
     * @var string
     */
    protected $filterButton = '[data-action="grid-filter-expand"]';

    /**
     * @param $actionName
     * Check grid header contain action name
     * @return bool
     */
    public function gridHeaderContainActionName($actionName){
        return $this->_rootElement->find(sprintf($this->actionNameElement, $actionName), Locator::SELECTOR_XPATH)->isPresent();
    }

    /**
     * check grid header contain filter
     * @return bool
     */
    public function gridHeaderContainFilter(){
        parent::waitFilterToLoad();
        $toggleFilterButton = $this->_rootElement->find($this->filterButton);
        $searchButton = $this->_rootElement->find($this->searchButton);
        if($toggleFilterButton->isVisible() && $searchButton->isPresent()){
            return true;
        }
        return false;
    }
}