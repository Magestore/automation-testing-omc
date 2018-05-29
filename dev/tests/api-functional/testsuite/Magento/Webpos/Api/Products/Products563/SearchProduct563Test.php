<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/29/18
 * Time: 5:56 PM
 */

namespace Magento\Webpos\Api\Products\Products563;

use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestFramework\TestCase\WebapiAbstract;
use Magento\Framework\Webapi\Rest\Request as RestRequest;
/**
 * Class SearchProduct563Test
 * @package Magento\Webpos\Api\Products\Products563
 */
class SearchProduct563Test extends WebapiAbstract
{
    /**
     * const PRODUCT_RESOURCE_PATH
     */
    const PRODUCT_RESOURCE_PATH = '/V1/webpos/products';

    /**
     * const SUB_PRODUCT_RESOURCE_PATH
     */
    const SUB_PRODUCT_RESOURCE_PATH = '/563/options?session=';

    /**
     * @var \Magento\Webpos\Api\Staff\LoginTest $currentSession
     */
    protected $currentSession;

    protected function setUp()
    {
        $this->currentSession = Bootstrap::getObjectManager()->get('\Magento\Webpos\Api\Staff\LoginTest');
    }

    /**
     * Api Name: Call API Search Products 563
     */
    public function callAPISearchProducts563()
    {
        $session = $this->currentSession->testStaffLogin();
        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::PRODUCT_RESOURCE_PATH.self::SUB_PRODUCT_RESOURCE_PATH.$session,
                'httpMethod' => RestRequest::HTTP_METHOD_GET,
            ],
        ];
        $results = $this->_webApiCall($serviceInfo);
        //\Zend_Debug::dump($results);
        return $results;
    }
    /**
     * Api Name: Test Search Products 563
     */
    public function testSearchProducts563(){
        $results = $this->callAPISearchProducts563();
        self::assertNotNull(
            $results,
            'result is not TRUE'
        );
        $keys = [
            'custom_options',
            'configurable_options',
            'optionLabel',
            'color',
            'json_config',
            'code',
            'label',
            'options',
            'products'
        ];
        $i = 0;
        $arrays = [];
        foreach ($keys as $key) {
            if (strlen(strstr($results, $key)) > 0) {
                $arrays[$i] = true;
            } else {
                $arrays[$i] = false;
            }
            $i = $i + 1;
        }
        foreach ($arrays as $array) {
            self::assertTrue(
                $array,
                $key . "The key ".$array." can not found in results. The result was wrong. Check API getAPISearchProducts563. ".self::PRODUCT_RESOURCE_PATH.self::SUB_PRODUCT_RESOURCE_PATH
            );
        }
    }
}