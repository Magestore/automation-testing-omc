<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 25/12/2017
 * Time: 13:17
 */

namespace Magento\Webpos\Api\Catalog;

use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestFramework\TestCase\WebapiAbstract;
use Magento\Framework\Webapi\Rest\Request as RestRequest;
/**
 * Class CategoryRepositoryTest
 * @package Magento\Webpos\Api\Catalog
 */
class CategoryRepositoryTest extends WebapiAbstract
{
    const RESOURCE_PATH = '/V1/webpos/categories/';

    /**
     * @var \Magento\Webpos\Api\Catalog\Constraint\CategoryRepository
     */
    protected $categoryRepository;

    protected function setUp()
    {
        $this->categoryRepository = Bootstrap::getObjectManager()->get('\Magento\Webpos\Api\Catalog\Constraint\CategoryRepository');
    }

    /**
     * Get List Categories
     */
    public function testGetList()
    {
        $requestData = [
            'searchCriteria' => [
                'current_page' => 1,
                'page_size' => 300
            ]
        ];

        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH . '?' . http_build_query($requestData) ,
                'httpMethod' => RestRequest::HTTP_METHOD_GET,
            ]
        ];

        $results = $this->_webApiCall($serviceInfo, $requestData);
        \Zend_Debug::dump($results);

        // Dump the result to check "How does it look like?"
//         \Zend_Debug::dump($results);

        self::assertGreaterThanOrEqual(
            1,
            $results['total_count'],
            "Result doesn't have any item (total_count < 1)"
        );
        // Get the key constraint for API testGetList. Call From Folder Constraint
        $keys = $this->categoryRepository->GetListCategories();

        foreach ($keys['items'][0] as $key) {
            self::assertContains(
                $key,
                array_keys($results['items'][0]),
                $key . " key is not in found in result['items'][0]'s keys"
            );
        }
    }
}