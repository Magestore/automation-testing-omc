<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 07/12/2017
 * Time: 13:21
 */

namespace Magento\BarcodeSuccess\Test\Block\Adminhtml\BarcodeListing\Generate\Form\Section\ProductsToGenerate;
use Magento\Ui\Test\Block\Adminhtml\DataGrid;

/**
 * Barcode generate grid.
 */
class Grid extends DataGrid
{
    /**
     * Grid fields map
     *
     * @var array
     */
    protected $filters = [
        'name' => [
            'selector' => 'input[name="name"]',
        ],
        'sku' => [
            'selector' => 'input[name="sku"]',
        ],
        'type' => [
            'selector' => 'select[name="type_id"]',
            'input' => 'select',
        ],
    ];

}
