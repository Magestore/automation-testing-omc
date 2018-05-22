<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/18/18
 * Time: 5:16 PM
 */

namespace Magento\Webpos\Api\Categories;

use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestFramework\TestCase\WebapiAbstract;
use Magento\Framework\Webapi\Rest\Request as RestRequest;
/**
 * Class SearchCategoriesCriteriaTest
 * @package Magento\Webpos\Api\Categories
 */
class SearchCategoriesCriteriaTest extends WebapiAbstract
{
    /**
     * const CATEGORIES_T_RESOURCE_PATH
     */
    const CATEGORIES_T_RESOURCE_PATH = '/V1/webpos/categories';

    /**
     * const GET_LIST_RESOURCE_PATH
     */
    const GET_LIST_RESOURCE_PATH = '/?searchCriteria%5Bcurrent_page%5D=1&searchCriteria%5Bpage_size%5D=300&website_id=1&session=';

    /**
     * @var \Magento\Webpos\Api\Staff\LoginTest $currentSession
     */
    protected $currentSession;

    protected function setUp()
    {
        $this->currentSession = Bootstrap::getObjectManager()->get('\Magento\Webpos\Api\Staff\LoginTest');
    }

    /**
     * Api Name: Call Get List Categories
     */
    public function callAPIGetListCategories()
    {
        $session = $this->currentSession->testStaffLogin();
        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::CATEGORIES_T_RESOURCE_PATH.self::GET_LIST_RESOURCE_PATH.$session,
                'httpMethod' => RestRequest::HTTP_METHOD_GET,
            ],
        ];
        $results = $this->_webApiCall($serviceInfo);
//        \Zend_Debug::dump($results);
        return $results;
    }
    /**
     * Api Name: Test Get List Categories
     */
    public function testGetListCategories(){
        $results = $this->callAPIGetListCategories();
        self::assertNotNull(
            $results,
            'result is not TRUE'
        );
        $key1 = [
            'items',
            'first_categories',
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
            'items' => [
                '0' => [
                    'id',
                    'name',
                    'children',
                    'image',
                    'position',
                    'level',
                    'first_category',
                    'parent_id',
                    'path',
                ]
            ]
        ];
        foreach ($key2['items'][0] as $key) {
            self::assertContains(
                $key,
                array_keys($results['items'][0]),
                $key . " key is not in found in results['items'][0]'s keys"
            );
        }
        $key3 = [
            'search_criteria' => [
                'filter_groups',
                'page_size',
                'current_page'
            ]
        ];
        foreach ($key3['search_criteria'] as $key) {
            self::assertContains(
                $key,
                array_keys($results['search_criteria']),
                $key . " key is not in found in results['search_criteria']'s keys"
            );
        }
    }
}