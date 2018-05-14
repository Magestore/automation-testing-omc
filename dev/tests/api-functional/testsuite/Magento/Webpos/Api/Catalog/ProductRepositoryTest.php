<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 25/12/2017
 * Time: 13:20
 */

namespace Magento\Webpos\Api\Catalog;

use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestFramework\TestCase\WebapiAbstract;
use Magento\Framework\Webapi\Rest\Request as RestRequest;
/**
 * Class ProductRepositoryTest
 * @package Magento\Webpos\Api\Catalog
 */
class ProductRepositoryTest extends WebapiAbstract
{
    const RESOURCE_PATH = '/V1/webpos/productlist/';
    const GET_OPTIONS_RESOURCE_PATH = '/V1/webpos/products/';

    /**
     * @var \Magento\Webpos\Api\Catalog\Constraint\ProductRepository
     */
    protected $productRepository;

    protected function setUp()
    {
        $this->productRepository = Bootstrap::getObjectManager()->get('\Magento\Webpos\Api\Catalog\Constraint\ProductRepository');
    }

    /**
     * Get Product List
     */
    public function testGetList()
    {
        $requestData = [
            'show_out_stock' => 1,
            'searchCriteria' => [
                'current_page' => 1,
                'page_size' => 32,
                'sortOrders' =>
                [
                    '1' => [
                        'field' => 'name',
                        'direction' => 'ASC'
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
        // \Zend_Debug::dump($results);

        $this->assertNotNull($results);
        self::assertGreaterThanOrEqual(
            1,
            $results['total_count'],
            "Result doesn't have any item (total_count < 1)"
        );
        // Get the key constraint for API testGetList. Call From Folder Constraint
        $keys = $this->productRepository->GetProductList();

        foreach ($keys['items'][0] as $key) {
            self::assertContains(
                $key,
                array_keys($results['items'][0]),
                $key . " key is not in found in results['items'][0]'s keys"
            );
        }
    }

    /**
     * We need product has options like clothes: color, size etc.
     * Get Product Options
     */
    public function testGetOptions()
    {
        //You should not delete the option product. Because, this case will be run relate to option product has size or color like clothes.
        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::GET_OPTIONS_RESOURCE_PATH .'872/options?' ,
                'httpMethod' => RestRequest::HTTP_METHOD_GET,
            ]
        ];

        $results = $this->_webApiCall($serviceInfo);
        \Zend_Debug::dump($results);

        $this->assertNotNull($results);
    }
}