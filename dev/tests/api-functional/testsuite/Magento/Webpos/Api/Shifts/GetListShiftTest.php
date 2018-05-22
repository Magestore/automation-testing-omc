<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/18/18
 * Time: 4:02 PM
 */

namespace Magento\Webpos\Api\Shifts;

use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestFramework\TestCase\WebapiAbstract;
use Magento\Framework\Webapi\Rest\Request as RestRequest;
/**
 * Class GetListShiftTest
 * @package Magento\Webpos\Api\Shifts
 */
class GetListShiftTest extends WebapiAbstract
{
    const SHIFT_RESOURCE_PATH = '/V1/webpos/shifts';
    const GETLIST_RESOURCE_PATH = '/getlist?searchCriteria%5Bfilter_groups%5D%5B0%5D%5Bfilters%5D%5B0%5D%5Bfield%5D=pos_id&searchCriteria%5Bfilter_groups%5D%5B0%5D%5Bfilters%5D%5B0%5D%5Bvalue%5D=5&searchCriteria%5Bfilter_groups%5D%5B0%5D%5Bfilters%5D%5B0%5D%5Bcondition_type%5D=eq&searchCriteria%5BpageSize%5D=1&searchCriteria%5BcurrentPage%5D=1&searchCriteria%5Bsort_orders%5D%5B0%5D%5Bfield%5D=entity_id&searchCriteria%5Bsort_orders%5D%5B0%5D%5Bdirection%5D=DESC&website_id=1&session=';

    /**
     * @var \Magento\Webpos\Api\Staff\LoginTest $currentSession
     */
    protected $currentSession;

    protected function setUp()
    {
        $this->currentSession = Bootstrap::getObjectManager()->get('\Magento\Webpos\Api\Staff\LoginTest');
    }

    /**
     * Api Name: Call Get List Shift
     */
    public function callAPIGetListShift()
    {
        $session = $this->currentSession->testStaffLogin();
        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::SHIFT_RESOURCE_PATH.self::GETLIST_RESOURCE_PATH.$session,
                'httpMethod' => RestRequest::HTTP_METHOD_GET,
            ],
        ];
        $results = $this->_webApiCall($serviceInfo);
        return $results;
    }
    /**
     * Api Name: Test Get List Shift
     */
    public function testGetListShift(){
        $results = $this->callAPIGetListShift();
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
                $key . " key is not in found in result's keys"
            );
        }
        $key2 = [
            'search_criteria' => [
                'filter_groups',
                'sort_orders',
                'page_size',
                'current_page'
            ]
        ];
        foreach ($key2['search_criteria'] as $key) {
            self::assertContains(
                $key,
                array_keys($results['search_criteria']),
                $key . " key is not in found in results['search_criteria']'s keys"
            );
        }
        $key3 = [
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
                ],
                'page_size',
                'current_page'
            ]
        ];
        foreach ($key3['search_criteria']['filter_groups'][0]['filters'][0] as $key) {
            self::assertContains(
                $key,
                array_keys($results['search_criteria']['filter_groups'][0]['filters'][0]),
                $key . " key is not in found in results['search_criteria']['filter_groups'][0]['filters'[0]'s keys"
            );
        }
        foreach ($key3['search_criteria']['sort_orders'][0] as $key) {
            self::assertContains(
                $key,
                array_keys($results['search_criteria']['sort_orders'][0]),
                $key . " key is not in found in results['search_criteria']['sort_orders'][0]'s keys"
            );
        }
    }
}