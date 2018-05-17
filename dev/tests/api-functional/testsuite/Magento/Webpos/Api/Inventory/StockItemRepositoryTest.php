<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 26/12/2017
 * Time: 08:41
 */

namespace Magento\Webpos\Api\Inventory;

use Magento\TestFramework\TestCase\WebapiAbstract;
use Magento\Framework\Webapi\Rest\Request as RestRequest;
/**
 * Class StockItemRepositoryTest
 * @package Magento\Webpos\Api\Inventory
 */
class StockItemRepositoryTest extends WebapiAbstract
{
    const RESOURCE_PATH = '/V1/webpos/stockItems';

    /**
     * Get stock with option(config product)
     */
    public function testGetStockItems()
    {
        $searchCriteria = [
            'searchCriteria' => [
                'filter_groups' => [
                    '0' => [
                        'filters' => [
                            '0' => [
                                    'field' => 'e.entity_id',
                                    'value' => '1864',
                                    'condition_type' => 'eq',
                            ],
                        ],
                    ],
                ],
            ],
        ];
        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH . '?' . http_build_query($searchCriteria),
                'httpMethod' => RestRequest::HTTP_METHOD_GET,
            ],
        ];
        $results = $this->_webApiCall($serviceInfo, $searchCriteria);
        $this->assertNotNull($results);
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
                                'condition_type',
                            ]
                        ]
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
    }
}