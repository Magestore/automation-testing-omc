<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/16/18
 * Time: 3:52 PM
 */

namespace Magento\Webpos\Api\TaxClass;

use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestFramework\TestCase\WebapiAbstract;
/**
 * Class CartTaxClassTest
 * @package Magento\Webpos\Api\TaxClass
 */
class TaxClassTest extends WebapiAbstract
{
    /**
     * @var \Magento\Webpos\Api\Staff\LoginTest
     */
    protected $currentSession;

    const RESOURCE_PATH = '/V1/webpos/taxclass/list?';

    protected function setUp()
    {
        $this->currentSession = Bootstrap::getObjectManager()->create(\Magento\Webpos\Api\Staff\LoginTest::class);
    }

    /**
     * test Staff LoginTest
     */
    public function testSearchCriteria()
    {
        $sessionId = $this->currentSession->testStaffLogin();
        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH.'searchCriteria%5BcurrentPage%5D=1&searchCriteria%5BpageSize%5D=200&session='.$sessionId.'&website_id=1',
                'httpMethod' => \Magento\Framework\Webapi\Rest\Request::HTTP_METHOD_GET,
            ],
        ];
        $results = $this->_webApiCall($serviceInfo);
        $key1 = [
            'items',
            'search_criteria',
            'total_count'
        ];
        $key2 = [
            'items' => [
                'class_id',
                'class_name',
                'class_type'
            ],
            'search_criteria' => [
                'filter_groups',
                'page_size',
                'current_page'
            ]
        ];
        foreach ($key1 as $key) {
            self::assertContains(
                $key,
                array_keys($results),
                $key . " key is not in found in results's keys"
            );
        }
        foreach ($key2['items'] as $key) {
            self::assertContains(
                $key,
                array_keys($results['items'][0]),
                $key . " key is not in found in results['items'][0]'s keys"
            );
        }
        foreach ($key2['search_criteria'] as $key) {
            self::assertContains(
                $key,
                array_keys($results['search_criteria']),
                $key . " key is not in found in results['search_criteria']'s keys"
            );
        }
        return $results;
    }
}