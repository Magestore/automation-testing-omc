<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/18/18
 * Time: 5:35 PM
 */

namespace Magento\Webpos\Api\ProductList;

use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestFramework\TestCase\WebapiAbstract;
use Magento\Framework\Webapi\Rest\Request as RestRequest;
/**
 * Class ProductListOutOfStockTest
 * @package Magento\Webpos\Api\ProductList
 */
class ProductListOutOfStockTest extends WebapiAbstract
{
    /**
     * const CATEGORIES_T_RESOURCE_PATH
     */
    const PRODUCT_LIST_RESOURCE_PATH = '/V1/webpos/productlist';

    /**
     * const GET_LIST_RESOURCE_PATH 1
     */
    const GET_LIST_RESOURCE_PATH1 = '/?show_out_stock=1&searchCriteria%5Bcurrent_page%5D=1&searchCriteria%5Bpage_size%5D=32&searchCriteria%5BsortOrders%5D%5B1%5D%5Bfield%5D=name&searchCriteria%5BsortOrders%5D%5B1%5D%5Bdirection%5D=ASC&website_id=1&session=';

    /**
     * @var \Magento\Webpos\Api\Staff\LoginTest $currentSession
     */
    protected $currentSession;

    protected function setUp()
    {
        $this->currentSession = Bootstrap::getObjectManager()->get('\Magento\Webpos\Api\Staff\LoginTest');
    }

    /**
     * Api Name: Call Get List Products
     */
    public function callAPIGetListProducts()
    {
        $session = $this->currentSession->testStaffLogin();
        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::PRODUCT_LIST_RESOURCE_PATH.self::GET_LIST_RESOURCE_PATH1.$session,
                'httpMethod' => RestRequest::HTTP_METHOD_GET,
            ],
        ];
        $results = $this->_webApiCall($serviceInfo);
        //\Zend_Debug::dump($results);
        return $results;
    }
    /**
     * Api Name: Test Get List Products Out Of Stock
     */
    public function testGetListProductsOutOfStock(){
        $results = $this->callAPIGetListProducts();
        self::assertNotNull(
            $results,
            'result is not TRUE'
        );
        $key1 = [
            'items',
            'search_criteria',
            'total_count'
        ];
        foreach ($key1 as $key) {
            self::assertContains(
                $key,
                array_keys($results),
                $key . " key is not in found in result's keys. Has any product developer or API designer been deleted this key."
            );
        }
        $key2 = [
            'items' => [
                0 => [
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
                    'stock',
                    'tier_prices',
                    'tax_class_id',
                    'options',
                    'search_string',
                    'barcode_string',
                    'is_virtual',
                    'customercredit_value',
                    'storecredit_type',
                    "giftvoucher_value",
                    "giftvoucher_select_price_type",
                    "giftvoucher_price",
                    "giftvoucher_from",
                    "giftvoucher_to",
                    "giftvoucher_dropdown",
                    "giftvoucher_price_type",
                    "giftvoucher_template",
                    "giftvoucher_type",
                    "allow_open_amount",
                    "giftcard_amounts",
                    "open_amount_min",
                    "open_amount_max",
                    "giftcard_type",
                    "is_in_stock",
                    "minimum_qty",
                    "maximum_qty",
                    "qty",
                    "is_salable",
                    "qty_increments",
                    "enable_qty_increments",
                    "is_qty_decimal"
                ]
            ]
        ];
        foreach ($key2['items'][0] as $key) {
            self::assertContains(
                $key,
                array_keys($results['items'][0]),
                $key . " key is not in found in results['items'][0]'s keys. Has any product developer or API designer been deleted this key."
            );
        }
        $key3 = [
            'search_criteria' => [
                'filter_groups',
                'sort_orders',
                'page_size',
                'current_page'
            ]
        ];
        foreach ($key3['search_criteria'] as $key) {
            self::assertContains(
                $key,
                array_keys($results['search_criteria']),
                $key . " key is not in found in results['search_criteria']'s keys. Has any product developer or API designer been deleted this key."
            );
        }
        $key4 = [
            'search_criteria' => [
                'sort_orders' => [
                    'field',
                    'direction',
                ]
            ]
        ];
        foreach ($key4['search_criteria']['sort_orders'] as $key) {
            self::assertContains(
                $key,
                array_keys($results['search_criteria']['sort_orders']),
                $key . " key is not in found in results['search_criteria']['sort_orders']'s keys. Has any product developer or API designer been deleted this key."
            );
        }
    }
}