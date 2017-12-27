<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/27/2017
 * Time: 8:13 AM
 */

namespace Magento\PurchaseOrderSuccess\Test\Block\Adminhtml\Supplier;

use Magento\Ui\Test\Block\Adminhtml\DataGrid;

class SupplierGrid extends DataGrid
{
    protected $filters = [
        'supplier_code' => [
            'selector' => '[name="supplier_code"]',
        ],
    ];
}