<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/16/18
 * Time: 4:20 PM
 */

namespace Magento\Webpos\Api\PostList;

use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestFramework\TestCase\WebapiAbstract;
/**
 * Class PostListTest
 * @package Magento\Webpos\Api\PostList
 */
class PostListTest extends WebapiAbstract
{
    /**
     * @var \Magento\Webpos\Api\Staff\LoginTest
     */
    protected $currentSession;

    const RESOURCE_PATH = '/V1/webpos/poslist/?';
    const SUB_RESOURCE = 'searchCriteria%5Bfilter_groups%5D%5B0%5D%5Bfilters%5D%5B0%5D%5Bfield%5D=staff_id&searchCriteria%5Bfilter_groups%5D%5B0%5D%5Bfilters%5D%5B0%5D%5Bvalue%5D=1&searchCriteria%5Bfilter_groups%5D%5B0%5D%5Bfilters%5D%5B0%5D%5Bcondition_type%5D=eq&searchCriteria%5BsortOrders%5D%5B0%5D%5Bfield%5D=pos_name&searchCriteria%5BsortOrders%5D%5B0%5D%5Bdirection%5D=ASC&';

    protected function setUp()
    {
        $this->currentSession = Bootstrap::getObjectManager()->create(\Magento\Webpos\Api\Staff\LoginTest::class);
    }

    /**
     * call API Post List Search Criteria
     */
    public function callAPIPostListSearchCriteria()
    {
        $sessionId = $this->currentSession->testStaffLogin();
        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH.self::SUB_RESOURCE.$sessionId.'session='.$sessionId.'&website_id=1',
                'httpMethod' => \Magento\Framework\Webapi\Rest\Request::HTTP_METHOD_GET,
            ],
        ];
        $results = $this->_webApiCall($serviceInfo);
        return $results;
    }
    /**
     * test API Post List Search Criteria
     */
    public function testPostListSearchCriteria() {
        $results = $this->callAPIPostListSearchCriteria();
        $key1 = [
            'items',
            'search_criteria',
            'total_count'
        ];
        $key2 = [
            'search_criteria' => [
                'filter_groups' => [
                    0 => [
                        'filters' => [
                            0 => [
                                'field',
                                'value',
                                'condition_type'
                            ]
                        ]
                    ]
                ],
                'sort_orders' => [
                    0 => [
                        'field',
                        'direction'
                    ]
                ]
            ]
        ];
        foreach ($key1 as $key) {
            self::assertContains(
                $key,
                array_keys($results),
                $key . " key is not in found in results's keys"
            );
        }
        foreach ($key2['search_criteria']['filter_groups'][0]['filters'][0] as $key) {
            self::assertContains(
                $key,
                array_keys($results['search_criteria']['filter_groups'][0]['filters'][0]),
                $key . " key is not in found in results['search_criteria']['filter_groups'][0]['filters'][0]'s keys"
            );
        }
        foreach ($key2['search_criteria']['sort_orders'][0] as $key) {
            self::assertContains(
                $key,
                array_keys($results['search_criteria']['sort_orders'][0]),
                $key . " key is not in found in results['sort_orders']['filter_groups'][0]'s keys"
            );
        }
    }
}