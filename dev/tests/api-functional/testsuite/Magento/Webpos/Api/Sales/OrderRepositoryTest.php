<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 25/12/2017
 * Time: 14:59
 */

namespace Magento\Webpos\Api\Sales;

use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestFramework\TestCase\WebapiAbstract;
use Magento\Framework\Webapi\Rest\Request as RestRequest;
/**
 * Class OrderRepositoryTest
 * @package Magento\Webpos\Api\Sales
 */
class OrderRepositoryTest extends WebapiAbstract
{
    const RESOURCE_PATH = '/V1/webpos/orders/';

    /**
     * @var \Magento\Webpos\Api\Sales\Constraint\OrderRepository
     */
    protected $orderRepository;

    protected function setUp()
    {
        $this->orderRepository = Bootstrap::getObjectManager()->get('\Magento\Webpos\Api\Sales\Constraint\OrderRepository');
    }

    /**
     * API Name: Get List Order
     */
    public function testGetList()
    {
        $requestData = [
            'searchCriteria' => [
                'current_page' => 1,
                'page_size' => 10,
                'sortOrders' => [
                    '0' => [
                        'field' => 'created_at',
                        'direction' => 'DESC',
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
//         \Zend_Debug::dump($results);

        $this->assertNotNull($results);
        $this->assertGreaterThanOrEqual(
            '1',
            $results['total_count'],
            'The results doesn\'t have items.'
        );
        // Get the key constraint for API Get List Order. Call From Folder Constraint
        $keys = $this->orderRepository->GetList();

        $key1 = $keys['key1'];
        foreach ($key1['items'][0] as $key) {
            self::assertContains(
                $key,
                array_keys($results['items'][0]),
                $key . " key is not in found in result['items'][0]'s keys"
            );
        }

        $key2 = $keys['key2'];
        foreach ($key2['items'][0]['webpos_order_payments'][0] as $key) {
            self::assertContains(
                $key,
                array_keys($results['items'][0]['webpos_order_payments'][0]),
                $key . " key is not in found in results['items'][0]['webpos_order_payments'][0]'s keys"
            );
        }
        foreach ($key2['items'][0]['items_info_buy']['items'][0] as $key) {
            self::assertContains(
                $key,
                array_keys($results['items'][0]['items_info_buy']['items'][0]),
                $key . " key is not in found in results['items'][0]['items_info_buy']['items'][0]'s keys"
            );
        }
        foreach ($key2['items'][0]['items'][0] as $key) {
            self::assertContains(
                $key,
                array_keys($results['items'][0]['items'][0]),
                $key . " key is not in found in results['items'][0['items'][0]'s keys"
            );
        }
        foreach ($key2['items'][0]['billing_address'] as $key) {
            self::assertContains(
                $key,
                array_keys($results['items'][0]['billing_address']),
                $key . " key is not in found in results['items'][0]['billing_address']'s keys"
            );
        }
        foreach ($key2['items'][0]['payment'] as $key) {
            self::assertContains(
                $key,
                array_keys($results['items'][0]['payment']),
                $key . " key is not in found in results['items'][0]['payment']'s keys"
            );
        }
        foreach ($key2['items'][0]['status_histories'][0] as $key) {
            self::assertContains(
                $key,
                array_keys($results['items'][0]['status_histories'][0]),
                $key . " key is not in found in results['items'][0]['status_histories'][0]'s keys"
            );
        }
        foreach ($key2['items'][0]['extension_attributes']['shipping_assignments'][0]['shipping']['address'] as $key) {
            self::assertContains(
                $key,
                array_keys($results['items'][0]['extension_attributes']['shipping_assignments'][0]['shipping']['address']),
                $key . " key is not in found in results['items'][0]['extension_attributes']['shipping_assignments'][0]['shipping']['address']'s keys"
            );
        }
        foreach ($key2['items'][0]['extension_attributes']['shipping_assignments'][0]['shipping']['total'] as $key) {
            self::assertContains(
                $key,
                array_keys($results['items'][0]['extension_attributes']['shipping_assignments'][0]['shipping']['total']),
                $key . " key is not in found in results['items'][0]['extension_attributes']['shipping_assignments'][0]['shipping']['total']'s keys"
            );
        }
    }

    /**
     * API Name: Order add comment
     */
    public function testAddComment()
    {
        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH . '16/comments/?',
                'httpMethod' => RestRequest::HTTP_METHOD_POST,
            ]
        ];

        $requestData = [
            'statusHistory' => [
                'parentId' => '16',
                'comment' => 'Test add comment\n',
                'isVisibleOnFront' => '1',
                'entityName' => 'string',
                'createdAt' => '2017-12-19 10:44:12.782'
            ]
        ];

        $results = $this->_webApiCall($serviceInfo, $requestData);

        // Dump the result to check "How does it look like?"
//         \Zend_Debug::dump($results);

        $this->assertNotNull($results);
        // Get the key constraint for API Order add comment. Call From Folder Constraint
        $keys = $this->orderRepository->GetList();

        $key1 = $keys['key1'];
        foreach ($key1 as $key) {
            self::assertContains(
                $key,
                array_keys($results),
                $key . " key is not in found in result['items'][0]'s keys"
            );
        }

        $key2 = $keys['key2'];
        foreach ($key2['items_info_buy']['items'][0] as $key) {
            self::assertContains(
                $key,
                array_keys($results['items_info_buy']['items'][0]),
                $key . " key is not in found in results['items_info_buy']['items'][0]'s keys"
            );
        }
        foreach ($key2['items'][0] as $key) {
            self::assertContains(
                $key,
                array_keys($results['items'][0]),
                $key . " key is not in found in results['items'][0]'s keys"
            );
        }
        foreach ($key2['billing_address'] as $key) {
            self::assertContains(
                $key,
                array_keys($results['billing_address']),
                $key . " key is not in found in results['billing_address']'s keys"
            );
        }
        foreach ($key2['payment'] as $key) {
            self::assertContains(
                $key,
                array_keys($results['payment']),
                $key . " key is not in found in results['payment']'s keys"
            );
        }
        foreach ($key2['status_histories'][0] as $key) {
            self::assertContains(
                $key,
                array_keys($results['status_histories'][0]),
                $key . " key is not in found in results['status_histories'][0]'s keys"
            );
        }
    }
}