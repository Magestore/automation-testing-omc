<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 25/12/2017
 * Time: 13:24
 */

namespace Magestore\Webpos\Api\Catalog;

use Magento\TestFramework\TestCase\WebapiAbstract;
use Magento\Framework\Webapi\Rest\Request as RestRequest;
/**
 * Class SwatchRepositoryTest
 * @package Magestore\Webpos\Api\Catalog
 */
class SwatchRepositoryTest extends WebapiAbstract
{
    const RESOURCE_PATH = '/V1/webpos/products/';

    /**
     * GET ColorSwatch
     */
    public function testGetList()
    {
        $requestData = [
            'searchCriteria' => [
                'pageSize' => 200,
                'currentPage' => 1,
            ]
        ];

        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH . 'swatch/search?' . http_build_query($requestData) ,
                'httpMethod' => RestRequest::HTTP_METHOD_GET,
            ]
        ];

        $results = $this->_webApiCall($serviceInfo, $requestData);

        // Dump the result to check "How does it look like?"
         \Zend_Debug::dump($results);

        $this->assertNotNull($results);
        self::assertGreaterThanOrEqual(
            1,
            $results['total_count'],
            "Result doesn't have any item (total_count < 1)"
        );
        $key1 = [
            'items' => [
                '0' => [
                    'attribute_id',
                    'attribute_code',
                    'attribute_label',
                    'attribute_label',
                    'swatches',
                ]
            ]
        ];
        foreach ($key1['items'][0] as $key) {
            self::assertContains(
                $key,
                array_keys($results['items'][0]),
                $key . " key is not in found in results['items'][0]'s keys"
            );
        }
        $key2 = [
            'items' => [
                '0' => [
                    'swatches' => [
                        '49' => [
                            'swatch_id',
                            'option_id',
                            'store_id',
                            'type',
                            'value',
                        ]
                    ],
                ]
            ]
        ];
        foreach ($key2['items'][0]['swatches'][49] as $key) {
            self::assertContains(
                $key,
                array_keys($results['items'][0]['swatches'][49]),
                $key . " key is not in found in results['items'][0]['swatches'][49]'s keys"
            );
        }
    }
}