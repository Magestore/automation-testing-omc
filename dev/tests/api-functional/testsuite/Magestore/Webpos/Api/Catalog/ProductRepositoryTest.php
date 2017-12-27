<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 25/12/2017
 * Time: 13:20
 */

namespace Magestore\Webpos\Api\Catalog;

use Magento\TestFramework\TestCase\WebapiAbstract;
use Magento\Framework\Webapi\Rest\Request as RestRequest;
/**
 * Class ProductRepositoryTest
 * @package Magestore\Webpos\Api\Catalog
 */
class ProductRepositoryTest extends WebapiAbstract
{
    const RESOURCE_PATH = '/V1/webpos/productlist/';
    const GET_OPTIONS_RESOURCE_PATH = '/V1/webpos/products/';

    /**
     * Get Product List
     */
    public function testGetList()
    {
        $requestData = [
            'show_out_stock' => 1,
            'searchCriteria' => [
                'current_page' => 1,
                'page_size' => 32,
                'sortOrders' =>
                [
                    '1' => [
                        'field' => 'name',
                        'direction' => 'ASC'
                    ]
                ]
            ]
        ];

        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH . '?' . http_build_query($requestData) ,
                'httpMethod' => RestRequest::HTTP_METHOD_GET,
            ]
        ];

        $results = $this->_webApiCall($serviceInfo, $requestData);

        // Dump the result to check "How does it look like?"
        // \Zend_Debug::dump($results);

        $this->assertNotNull($results);
        self::assertGreaterThanOrEqual(
            1,
            $results['total_count'],
            "Result doesn't have any item (total_count < 1)"
        );
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
                    'extension_attributes',
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
        foreach ($keys['items'][0] as $key) {
            self::assertContains(
                $key,
                array_keys($results['items'][0]),
                $key . " key is not in found in results['items'][0]'s keys"
            );
        }
    }

    /**
     * Get Product Options
     */
    public function testGetOptions()
    {
        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::GET_OPTIONS_RESOURCE_PATH .'872/options?' ,
                'httpMethod' => RestRequest::HTTP_METHOD_GET,
            ]
        ];

        $results = $this->_webApiCall($serviceInfo);
        \Zend_Debug::dump($results);

        $this->assertNotNull($results);
    }
}