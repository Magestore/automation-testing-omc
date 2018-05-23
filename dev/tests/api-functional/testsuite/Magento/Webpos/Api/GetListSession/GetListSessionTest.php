<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/18/18
 * Time: 6:10 PM
 */

namespace Magento\Webpos\Api\GetListSession;

use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestFramework\TestCase\WebapiAbstract;
use Magento\Framework\Webapi\Rest\Request as RestRequest;
/**
 * Class GetListSessionTest
 * @package Magento\Webpos\Api\GetListSession
 */
class GetListSessionTest extends WebapiAbstract
{
    /**
     * const SHIFT_LIST_RESOURCE_PATH
     */
    const SHIFT_LIST_RESOURCE_PATH = '/V1/webpos/shifts/getlist';

    /**
     * const GET_LIST_RESOURCE_PATH 1
     */
    const SUB_SHIFT_LIST_RESOURCE_PATH = '?searchCriteria%5Bfilter_groups%5D%5B0%5D%5Bfilters%5D%5B0%5D%5Bfield%5D=pos_id&searchCriteria%5Bfilter_groups%5D%5B0%5D%5Bfilters%5D%5B0%5D%5Bvalue%5D=3&searchCriteria%5Bfilter_groups%5D%5B0%5D%5Bfilters%5D%5B0%5D%5Bcondition_type%5D=eq&searchCriteria%5BpageSize%5D=1&searchCriteria%5BcurrentPage%5D=1&searchCriteria%5Bsort_orders%5D%5B0%5D%5Bfield%5D=entity_id&searchCriteria%5Bsort_orders%5D%5B0%5D%5Bdirection%5D=DESC&session=';

    /**
     * @var \Magento\Webpos\Api\Staff\LoginTest $currentSession
     */
    protected $currentSession;

    protected function setUp()
    {
        $this->currentSession = Bootstrap::getObjectManager()->get('\Magento\Webpos\Api\Staff\LoginTest');
    }

    /**
     * Api Name: Call Get List Shift Session
     */
    public function callAPIGetListShiftSession()
    {
        $session = $this->currentSession->testStaffLogin();
        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::SHIFT_LIST_RESOURCE_PATH.self::SUB_SHIFT_LIST_RESOURCE_PATH.$session,
                'httpMethod' => RestRequest::HTTP_METHOD_GET,
            ],
        ];
        $requestData = [
            "searchCriteria" => [
                "filter_groups" => [
                    0 => [
                        'filters' => [
                            0 => [
                                'field' => 'pos_id',
                                'value' => '1',
                                'condition_type' => 'eq',
                            ]
                        ]
                    ]
                ],
                'pageSize' => 1,
                'currentPage' => 1,
                'sort_orders' => [
                    0 => [
                        'field' => 'entity_id',
                        'direction' => 'DESC',
                    ]
                ]
            ]
        ];
        $results = $this->_webApiCall($serviceInfo, $requestData);
        return $results;
    }
    /**
     * Api Name: Test Get List Products Out Of Stock
     */
    public function testGetListShiftSession(){
        $results = $this->callAPIGetListShiftSession();
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
                ]
            ]
        ];
        foreach ($key4['search_criteria']['filter_groups'][0]['filters'][0] as $key) {
            self::assertContains(
                $key,
                array_keys($results['search_criteria']['filter_groups'][0]['filters'][0]),
                $key . " key is not in found in results['search_criteria']['filter_groups'][0]['filters'][0]'s keys. Has any product developer or API designer been deleted this key."
            );
        }
    }
}