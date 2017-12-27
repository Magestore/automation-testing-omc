<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 25/12/2017
 * Time: 12:58
 */

namespace Magestore\Webpos\Api\Shift;

use Magento\TestFramework\TestCase\WebapiAbstract;
use Magento\Framework\Webapi\Rest\Request as RestRequest;
/**
 * Class ShiftRepositoryTest
 * @package Magestore\Webpos\Api\Shift
 */
class ShiftRepositoryTest extends WebapiAbstract
{
    const RESOURCE_PATH = '/V1/webpos/shifts/';

    /**
     * Get List Session
     */
    public function testGetList()
    {
        $requestData = [
            'searchCriteria' => [
                'filter_groups' => [
                    '0' => [
                        'filters' => [
                            '0' => [
                                'field' => 'pos_id',
                                'value' => '1',
                                'condition_type' => 'eq'
                            ]
                        ]
                    ]
                ],
                'pageSize' => 1,
                'currentPage' => 1,
                'sort_orders' => [
                    '0' => [
                        'field' => 'entity_id',
                        'direction' => 'DESC'
                    ]
                ]
            ]
        ];

        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH . 'getlist?' . http_build_query($requestData) ,
                'httpMethod' => RestRequest::HTTP_METHOD_GET,
            ]
        ];

        $results = $this->_webApiCall($serviceInfo, $requestData);
        \Zend_Debug::dump($results);
        $this->assertNotNull($results);
        self::assertGreaterThanOrEqual(
            1,
            $results['total_count'],
            "Result doesn't have any item (total_count < 1)"
        );
        $keys = [
            'entity_id',
            'shift_id',
            'staff_id',
            'location_id',
            'opened_at',
            'updated_at',
            'closed_at',
            'float_amount',
            'base_float_amount',
            'closed_amount',
            'base_closed_amount',
            'status',
            'cash_left',
            'base_cash_left',
            'closed_note',
            'opened_note',
            'total_sales',
            'base_total_sales',
            'balance',
            'base_balance',
            'cash_sale',
            'base_cash_sale',
            'cash_added',
            'base_cash_added',
            'cash_removed',
            'base_cash_removed',
            'session',
            'base_currency_code',
            'shift_currency_code',
            'store_id',
            'pos_name',
            'pos_id',
            'sale_summary',
            'cash_transaction',
        ];
        foreach ($keys as $key) {
            self::assertContains(
                $key,
                array_keys($results['items'][0]),
                $key . " key is not in found in result['items'][0]'s keys"
            );
        }
    }

    /**
     * Action to close the session
     */
    public function closeSession()
    {
        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH . 'save?',
                'httpMethod' => RestRequest::HTTP_METHOD_POST,
            ]
        ];

        $requestData = [
            'shift' => [
                'cash_added' => 50,
                'opened_note' => 'null',
                'base_cash_removed' => 20,
                'entity_id' => 1,
                'status' => 2,
                'cash_sale' => 168.87,
                'staff_id' => 1,
                'base_cash_sale' => 168.87,
                'base_float_amount' => 0,
                'base_cash_left' => 198.87,
                'float_amount' => 0,
                'balance' => 198.87,
                'location_id' => 1,
                'base_total_sales' => 258.87,
                'cash_left' => 198.87,
                'total_sales' => 258.87,
                'closed_note' => 'null',
                'closed_at' => '2017-12-18 09:40:31',
                'base_closed_amount' => 198.87,
                'cash_removed' => 20,
                'closed_amount' => 198.87,
                'base_cash_added' => 50,
                'shift_id' => 'session_1514250244118',
                'base_balance' => 198.87,
                'shift_currency_code' => 'USD',
                'base_currency_code' => 'USD'
            ]
        ];

        $results = $this->_webApiCall($serviceInfo, $requestData);

        // Dump the result to check "How does it look like?"
        // \Zend_Debug::dump($results);
        return $results;
    }

    /**
     * Close Session
     */
    public function testSave()
    {
        $results = $this->closeSession();

        $this->assertNotNull($results);
        $key1 = [
            'entity_id',
            'shift_id',
            'staff_id',
            'location_id',
            'float_amount',
            'base_float_amount',
            'closed_amount',
            'base_closed_amount',
            'cash_left',
            'base_cash_left',
            'total_sales',
            'base_total_sales',
            'base_balance',
            'balance',
            'cash_sale',
            'base_cash_sale',
            'cash_added',
            'base_cash_added',
            'cash_removed',
            'base_cash_removed',
            'opened_at',
            'closed_at',
            'opened_note',
            'closed_note',
            'status',
            'base_currency_code',
            'shift_currency_code',
            'indexeddb_id',
            'updated_at',
            'pos_id',
            'profit_loss_reason',
            'sale_summary',
            'cash_transaction',
            'zreport_sales_summary',
            'pos_name',
        ];
        foreach ($key1 as $key) {
            self::assertContains(
                $key,
                array_keys($results),
                $key . " key is not in found in result['items'][0]'s keys"
            );
        }
        $key2 = [
            '0' => [
                'sale_summary' => [
                    '0' => [
                        'payment_method',
                        'payment_amount',
                        'base_payment_amount',
                        'method_title',
                    ]
                ],
                'cash_transaction' => [
                    '0' => [
                        'transaction_id',
                        'shift_id',
                        'location_id',
                        'order_id',
                        'value',
                        'base_value',
                        'balance',
                        'base_balance',
                        'created_at',
                        'note',
                        'type',
                        'base_currency_code',
                        'transaction_currency_code',
                        'indexeddb_id',
                        'updated_at',
                        'staff_id',
                        'staff_name',
                    ]
                ],
                'zreport_sales_summary' => [
                    'grand_total',
                    'discount_amount',
                    'total_refunded',
                    'giftvoucher_discount',
                    'rewardpoints_discount',
                ],
            ]
        ];
        foreach ($key2['0']['cash_transaction']['0'] as $key) {
            self::assertContains(
                $key,
                array_keys($results['0']['cash_transaction']['0']),
                $key . " key is not in found in results['0']['cash_transaction']['0']'s keys"
            );
        }
        foreach ($key2['0']['sale_summary']['0'] as $key) {
            self::assertContains(
                $key,
                array_keys($results['0']['sale_summary']['0']),
                $key . " key is not in found in results['0']['sale_summary']['0']'s keys"
            );
        }
        foreach ($key2['0']['zreport_sales_summary'] as $key) {
            self::assertContains(
                $key,
                array_keys($results['0']['zreport_sales_summary']),
                $key . " key is not in found in results['0']['zreport_sales_summary']'s keys"
            );
        }
    }

    /**
     * We need to setup the 'Create session before working in Store->Configuration and
     * Login to open session' for creating the session
     * Validate Session
     */
    public function testValidateSession()
    {
        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH . 'save?',
                'httpMethod' => RestRequest::HTTP_METHOD_POST,
            ]
        ];

        $values = $this->closeSession();
        $requestData = [
            'shift' => [
                'cash_added' => 50,
                'opened_note' => 'null',
                'base_cash_removed' => 20,
                'entity_id' => 3,
                'status' => 1,
                'cash_sale' => 168.87,
                'staff_id' => '1',
                'base_cash_sale' => 168.87,
                'base_float_amount' => 0,
                'base_cash_left' => 198.87,
                'float_amount' => 0,
                'balance' => 0,
                'location_id' => 1,
                'base_total_sales' => 258.87,
                'cash_left' => 198.87,
                'total_sales' => 258.87,
                'closed_note' => 'null',
                'closed_at' => '2017-12-18 09:41:29',
                'base_closed_amount' => 198.87,
                'cash_removed' => 20,
                'closed_amount' => 198.87,
                'base_cash_added' => 50,
                'pos_id' => $values[0]['pos_id'],
                'shift_id' => 'session_1514250244118',
                'base_balance' => 0,
                'shift_currency_code' => 'USD',
                'base_currency_code' => 'USD'
            ]
        ];

        $results = $this->_webApiCall($serviceInfo, $requestData);
        \Zend_Debug::dump($results);
        $this->assertNotNull($results);
        $key1 = [
            'entity_id',
            'shift_id',
            'staff_id',
            'location_id',
            'float_amount',
            'base_float_amount',
            'closed_amount',
            'base_closed_amount',
            'cash_left',
            'base_cash_left',
            'total_sales',
            'base_total_sales',
            'base_balance',
            'balance',
            'cash_sale',
            'base_cash_sale',
            'cash_added',
            'base_cash_added',
            'cash_removed',
            'base_cash_removed',
            'opened_at',
            'closed_at',
            'opened_note',
            'closed_note',
            'status',
            'base_currency_code',
            'shift_currency_code',
            'indexeddb_id',
            'updated_at',
            'pos_id',
            'profit_loss_reason',
            'sale_summary',
            'cash_transaction',
            'zreport_sales_summary',
            'pos_name',
        ];
        foreach ($key1 as $key) {
            self::assertContains(
                $key,
                array_keys($results),
                $key . " key is not in found in result['items'][0]'s keys"
            );
        }
        $key2 = [
            '0' => [
                'sale_summary' => [
                    '0' => [
                        'payment_method',
                        'payment_amount',
                        'base_payment_amount',
                        'method_title',
                    ]
                ],
                'cash_transaction' => [
                    '0' => [
                        'transaction_id',
                        'shift_id',
                        'location_id',
                        'order_id',
                        'value',
                        'base_value',
                        'balance',
                        'base_balance',
                        'created_at',
                        'note',
                        'base_currency_code',
                        'transaction_currency_code',
                        'indexeddb_id',
                        'updated_at',
                        'staff_id',
                        'staff_name',
                    ]
                ],
                'zreport_sales_summary' => [
                    'grand_total',
                    'discount_amount',
                    'total_refunded',
                    'giftvoucher_discount',
                    'rewardpoints_discount',
                ],
            ]
        ];
        foreach ($key2[0]['sale_summary'][0] as $key) {
            self::assertContains(
                $key,
                array_keys($results[0]['sale_summary'][0]),
                $key . " key is not in found in results[0]['sale_summary'][0]'s keys"
            );
        }
        foreach ($key2[0]['cash_transaction'][0] as $key) {
            self::assertContains(
                $key,
                array_keys($results[0]['cash_transaction'][0]),
                $key . " key is not in found in results[0]['cash_transaction'][0]'s keys"
            );
        }
        foreach ($key2[0]['zreport_sales_summary'] as $key) {
            self::assertContains(
                $key,
                array_keys($results[0]['zreport_sales_summary']),
                $key . " key is not in found in results[0]['sale_summary'][0]'s keys"
            );
        }
    }

    /**
     * We need to setup the 'Create session before working in Store->Configuration and
     * Login to open session' for creating the session
     * Open Session
     */
    public function testOpenSession()
    {
        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH . 'save?',
                'httpMethod' => RestRequest::HTTP_METHOD_POST,
            ]
        ];

        $requestData = [
            'shift' => [
                'opened_at' => '2017-12-18 09:45:07',
                'opened_note' => '',
                'base_currency_code' => 'USD',
                'status' => 0,
                'base_cash_removed' => 0,
                'cash_sale' => 0,
                'staff_id' => '1',
                'base_cash_sale' => 0,
                'base_float_amount' => 150,
                'base_cash_left' => 0,
                'float_amount' => 150,
                'balance' => 150,
                'location_id' => 1,
                'total_sales' => 0,
                'cash_left' => 0,
                'base_closed_amount' => 0,
                'closed_note' => '',
                'base_total_sales' => 0,
                'cash_removed' => 0,
                'closed_amount' => 0,
                'base_cash_added' => 150,
                'pos_id' => '1',
                'shift_id' => 'session_1514250244118',
                'base_balance' => 150,
                'shift_currency_code' => 'USD',
                'cash_added' => 150
            ]
        ];

        $results = $this->_webApiCall($serviceInfo, $requestData);
        \Zend_Debug::dump($results);
        $this->assertNotNull($results);
        $key1 = [
            'entity_id',
            'shift_id',
            'staff_id',
            'location_id',
            'float_amount',
            'base_float_amount',
            'closed_amount',
            'base_closed_amount',
            'cash_left',
            'base_cash_left',
            'total_sales',
            'base_total_sales',
            'base_balance',
            'balance',
            'cash_sale',
            'base_cash_sale',
            'cash_added',
            'base_cash_added',
            'cash_removed',
            'base_cash_removed',
            'opened_at',
            'closed_at',
            'opened_note',
            'closed_note',
            'status',
            'base_currency_code',
            'shift_currency_code',
            'indexeddb_id',
            'updated_at',
            'pos_id',
            'profit_loss_reason',
            'sale_summary',
            'cash_transaction',
            'zreport_sales_summary',
            'pos_name',
        ];
        foreach ($key1 as $key) {
            self::assertContains(
                $key,
                array_keys($results),
                $key . " key is not in found in result['items'][0]'s keys"
            );
        }
        $key2 = [
            '0' => [
                'sale_summary' => [
                    '0' => [
                        'payment_method',
                        'payment_amount',
                        'base_payment_amount',
                        'method_title',
                    ],
                ],
                'cash_transaction' => [
                    '0' => [
                        'transaction_id',
                        'shift_id',
                        'location_id',
                        'order_id',
                        'value',
                        'base_value',
                        'balance',
                        'base_balance',
                        'created_at',
                        'note',
                        'type',
                        'base_currency_code',
                        'transaction_currency_code',
                        'indexeddb_id',
                        'updated_at',
                        'staff_id',
                        'staff_name',
                    ],
                ],
                'zreport_sales_summary' => [
                    'grand_total',
                    'discount_amount',
                    'total_refunded',
                    'giftvoucher_discount',
                    'rewardpoints_discount',
                ],
            ]
        ];
        foreach ($key2[0]['sale_summary'][0] as $key) {
            self::assertContains(
                $key,
                array_keys($results[0]['sale_summary'][0]),
                $key . " key is not in found in results[0]['sale_summary'][0]'s keys"
            );
        }
        foreach ($key2[0]['cash_transaction'][0] as $key) {
            self::assertContains(
                $key,
                array_keys($results[0]['cash_transaction'][0]),
                $key . " key is not in found in results[0]['cash_transaction'][0]'s keys"
            );
        }
        foreach ($key2[0]['zreport_sales_summary'] as $key) {
            self::assertContains(
                $key,
                array_keys($results[0]['zreport_sales_summary']),
                $key . " key is not in found in results[0]['sale_summary'][0]'s keys"
            );
        }
    }
}