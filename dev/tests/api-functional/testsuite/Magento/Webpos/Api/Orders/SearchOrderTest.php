<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/29/18
 * Time: 6:33 PM
 */

namespace Magento\Webpos\Api\Orders;

use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestFramework\TestCase\WebapiAbstract;
use Magento\Framework\Webapi\Rest\Request as RestRequest;
/**
 * Class SearchOrderTest
 * @package Magento\Webpos\Api\Orders
 */
class SearchOrderTest extends WebapiAbstract
{
    /**
     * const ORDER_RESOURCE_PATH
     */
    const ORDER_RESOURCE_PATH = '/V1/webpos/orders';

    /**
     * const SUB_ORDER_RESOURCE_PATH
     */
    const SUB_ORDER_RESOURCE_PATH = '/?searchCriteria%5Bcurrent_page%5D=1&searchCriteria%5Bpage_size%5D=10&searchCriteria%5BsortOrders%5D%5B0%5D%5Bfield%5D=created_at&searchCriteria%5BsortOrders%5D%5B0%5D%5Bdirection%5D=DESC&website_id=1&session=';

    /**
     * @var \Magento\Webpos\Api\Staff\LoginTest $currentSession
     */
    protected $currentSession;

    protected function setUp()
    {
        $this->currentSession = Bootstrap::getObjectManager()->get('\Magento\Webpos\Api\Staff\LoginTest');
    }

    /**
     * Api Name: Call API Search Order
     */
    public function callAPISearchOrder()
    {
        $session = $this->currentSession->testStaffLogin();
        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::ORDER_RESOURCE_PATH.self::SUB_ORDER_RESOURCE_PATH.$session,
                'httpMethod' => RestRequest::HTTP_METHOD_GET,
            ],
        ];
        $results = $this->_webApiCall($serviceInfo);
        //\Zend_Debug::dump($results);
        return $results;
    }
    /**
     * Api Name: Test Search Order
     */
    public function testSearchOrder(){
        $results = $this->callAPISearchOrder();
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
                    'rewardpoints_earn',
                    'rewardpoints_spent',
                    'rewardpoints_discount',
                    'rewardpoints_base_discount',
                    'rewardpoints_refunded',
                    'gift_voucher_discount',
                    'base_gift_voucher_discount',
                    'gift_cards_amount',
                    'base_gift_cards_amount',
                    'base_customercredit_discount',
                    'customercredit_discount',
                    'base_customer_balance_amount',
                    'webpos_base_change',
                    'webpos_order_payments',
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
                'page_size'
            ]
        ];
        foreach ($key3['search_criteria'] as $key) {
            self::assertContains(
                $key,
                array_keys($results['search_criteria']),
                $key . " key is not in found in results['items']'s keys. Has any product developer or API designer been deleted this key."
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