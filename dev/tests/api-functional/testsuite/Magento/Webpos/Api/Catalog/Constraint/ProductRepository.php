<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 28/12/2017
 * Time: 13:55
 */

namespace Magento\Webpos\Api\Catalog\Constraint;

/**
 * Class ProductRepository
 * @package Magento\Webpos\Api\Catalog\Constraint
 */
class ProductRepository
{
    /**
     * Constraint set key for Get Product List
     * API: Get Product List
     */
    public function GetProductList()
    {
        $keys = [
            'items' => [
                '0' => [
                    'id',
                    'type_id',
                    'sku',
                    'name',
                    'price',
                    'final_price',
                    'description',
                    'status',
                    'updated_at',
                    'category_ids',
                    'qty_increment',
                    'image',
                    'images',
                    'stock',
                    'tier_prices',
                    'tax_class_id',
                    'options',
                    'search_string',
                    'barcode_string',
                    'is_virtual',
                    'customercredit_value',
                    'storecredit_type',
                    'giftvoucher_value',
                    'giftvoucher_select_price_type',
                    'giftvoucher_price',
                    'giftvoucher_from',
                    'giftvoucher_to',
                    'giftvoucher_dropdown',
                    'giftvoucher_price_type',
                    'giftvoucher_template',
                    'giftvoucher_type',
                    'is_in_stock',
                    'minimum_qty',
                    'maximum_qty',
                    'qty',
                    'is_salable',
                    'qty_increments',
                    'enable_qty_increments',
                    'is_qty_decimal',
                ]
            ]
        ];
        return $keys;
    }
}