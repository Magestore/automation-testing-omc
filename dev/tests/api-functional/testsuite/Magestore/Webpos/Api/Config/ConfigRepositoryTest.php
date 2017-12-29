<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 26/12/2017
 * Time: 08:11
 */

namespace Magestore\Webpos\Api\Config;

use Magento\TestFramework\TestCase\WebapiAbstract;
use Magento\Framework\Webapi\Rest\Request as RestRequest;
/**
 * Class ConfigRepositoryTest
 * @package Magestore\Webpos\Api\Config
 */
class ConfigRepositoryTest extends WebapiAbstract
{
    const RESOURCE_PATH = '/V1/webpos/configurations';

    /**
     * Get Configuration
     */
    public function testGetList()
    {
        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH .'?' ,
                'httpMethod' => RestRequest::HTTP_METHOD_GET,
            ]
        ];

        $results = $this->_webApiCall($serviceInfo);

        // Dump the result to check "How does it look like?"
        // \Zend_Debug::dump($results);

        $this->assertNotNull($results);
        foreach ($results['items'] as $item) {
            $this->assertNotNull($item['path']);
        }
        self::assertGreaterThanOrEqual(
            1,
            $results['total_count'],
            "The result doesn't have any item (total_count < 1)"
        );
        $keys = ['path', 'value'];
        foreach ($keys as $key) {
            self::assertContains(
                $key,
                array_keys($results['items'][0]),
                $key . " key is not in found in result['items'][0]'s keys"
            );
        }
    }
}