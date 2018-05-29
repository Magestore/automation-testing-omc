<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/29/18
 * Time: 5:42 PM
 */

namespace Magento\Webpos\Api\Products\Swatch;

use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestFramework\TestCase\WebapiAbstract;
use Magento\Framework\Webapi\Rest\Request as RestRequest;
/**
 * Class SearchSwatchTest
 * @package Magento\Webpos\Api\Products\Swatch
 */
class SearchSwatchTest extends WebapiAbstract
{
    /**
     * const PRODUCT_RESOURCE_PATH
     */
    const PRODUCT_RESOURCE_PATH = '/V1/webpos/products';

    /**
     * const SUB_PRODUCT_RESOURCE_PATH
     */
    const SUB_PRODUCT_RESOURCE_PATH = '/swatch/search?searchCriteria%5BpageSize%5D=200&searchCriteria%5BcurrentPage%5D=1&session=';

    /**
     * @var \Magento\Webpos\Api\Staff\LoginTest $currentSession
     */
    protected $currentSession;

    protected function setUp()
    {
        $this->currentSession = Bootstrap::getObjectManager()->get('\Magento\Webpos\Api\Staff\LoginTest');
    }

    /**
     * Api Name: Call API Search Swatch
     */
    public function callAPISearchSwatch()
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
     * Api Name: Test Search Swatch
     */
    public function testSearchSwatch(){
        $results = $this->callAPISearchSwatch();
        self::assertNotNull(
            $results,
            'result is not TRUE'
        );
        $key1 = [
            'items',
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
                    'attribute_id',
                    'attribute_code',
                    'attribute_label',
                    'swatches'
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
            'items' => [
                0 => [
                    'swatches' => [
                        '49' => [
                            'swatch_id',
                            'option_id',
                            'store_id',
                            'type',
                            'value',
                        ]
                    ]
                ]
            ]
        ];
        foreach ($key3['items'][0]['swatches']['49'] as $key) {
            self::assertContains(
                $key,
                array_keys($results['items'][0]['swatches']['49']),
                $key . " key is not in found in results['items'][0]['swatches']['49']'s keys. Has any product developer or API designer been deleted this key."
            );
        }
    }
}