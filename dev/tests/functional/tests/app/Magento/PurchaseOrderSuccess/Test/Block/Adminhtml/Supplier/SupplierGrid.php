<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/27/2017
 * Time: 8:13 AM
 */

namespace Magento\PurchaseOrderSuccess\Test\Block\Adminhtml\Supplier;

use Magento\Mtf\Client\Locator;
use Magento\Ui\Test\Block\Adminhtml\DataGrid;

class SupplierGrid extends DataGrid
{
    protected $filters = [
        'supplier_code' => [
            'selector' => '[name="supplier_code"]',
        ],
    ];

    protected $massActionButton = './/span[@class="action-menu-item" and text()="%s"]';
//
//    private $gridHeader = './/div[@class="admin__data-grid-header"]';
//
//    public function selectAction($action)
//    {
//        $actionType = is_array($action) ? key($action) : $action;
//        $this->getGridHeaderElement()->find($this->actionButton)->click();
//        $toggle = $this->getGridHeaderElement()->find(sprintf($this->actionList, $actionType), Locator::SELECTOR_XPATH);
//        $toggle->hover();
//        if ($toggle->isVisible() === false) {
//            $this->getGridHeaderElement()->find($this->actionButton)->click();
//        }
//        $toggle->click();
//        if (is_array($action)) {
//            $locator = sprintf($this->actionList, end($action));
//            $this->getGridHeaderElement()->find($locator, Locator::SELECTOR_XPATH)->hover();
//            $this->getGridHeaderElement()->find($locator, Locator::SELECTOR_XPATH)->click();
//        }
//    }
//
//    private function getGridHeaderElement()
//    {
//        return $this->_rootElement->find($this->gridHeader, Locator::SELECTOR_XPATH);
//    }

    public function selectAction($action)
    {
        $massActionButton = sprintf($this->massActionButton, $action);
        $this->_rootElement->find('.//button[@class="action-select"]', Locator::SELECTOR_XPATH)->click();
        $this->_rootElement->find($massActionButton, Locator::SELECTOR_XPATH)->click();
    }
}