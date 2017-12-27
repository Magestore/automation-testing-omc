<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 26/12/2017
 * Time: 07:50
 */

namespace Magestore\Webpos\Api\Shift;

use Magento\TestFramework\TestCase\WebapiAbstract;
use Magento\Framework\Webapi\Rest\Request as RestRequest;
/**
 * Class CashTransactionRepositoryTest
 * @package Magestore\Webpos\Api\Shift
 */
class CashTransactionRepositoryTest extends WebapiAbstract
{
    const RESOURCE_PATH = '/V1/webpos/cash_transaction/';

    /**
     * Need a API web to create a new shift to get the valid shift_id
     * Make Adjustment Session
     */
    public function testSave()
    {
        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH . 'save?',
                'httpMethod' => RestRequest::HTTP_METHOD_POST,
            ]
        ];

        $requestData = [
            'cashTransaction' => [
                'shift_id' => 'session_1514250244118',
                'transaction_currency_code' => 'USD',
                'note' => '',
                'base_value' => 50,
                'created_at' => '2017-12-18 07:59:00',
                'location_id' => 1,
                'value' => 50,
                'type' => 'add',
                'base_currency_code' => 'USD',
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
                $key . " key is not in found in results's keys"
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
                ]
            ]
        ];
        foreach ($key2[0]['sale_summary'][0] as $key) {
            self::assertContains(
                $key,
                array_keys($results[0]['sale_summary'][0]),
                $key . " key is not in found in results['sale_summary'][0]'s keys"
            );
        }
        foreach ($key2[0]['cash_transaction'][0] as $key) {
            self::assertContains(
                $key,
                array_keys($results[0]['cash_transaction'][0]),
                $key . " key is not in found in results['cash_transaction'][0]'s keys"
            );
        }
    }
}