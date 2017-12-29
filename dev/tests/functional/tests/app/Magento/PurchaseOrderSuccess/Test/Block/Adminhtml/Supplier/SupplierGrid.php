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
        'status' => [
            'selector' => '[data-role="advanced-select"]',
            'input' => '\Magento\PurchaseOrderSuccess\Test\Block\Adminhtml\Supplier\Filter\Status'
        ]
    ];

    protected $massActionButton = './/span[@class="action-menu-item" and text()="%s"]';

    public function selectAction($action)
    {
        $massActionButton = sprintf($this->massActionButton, $action);
        $this->_rootElement->find('.//button[@class="action-select"]', Locator::SELECTOR_XPATH)->click();
        $this->_rootElement->find($massActionButton, Locator::SELECTOR_XPATH)->click();
    }
}