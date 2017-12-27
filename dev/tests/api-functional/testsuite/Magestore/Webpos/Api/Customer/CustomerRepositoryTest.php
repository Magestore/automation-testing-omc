<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 25/12/2017
 * Time: 14:45
 */

namespace Magestore\Webpos\Api\Customer;

use Magento\TestFramework\TestCase\WebapiAbstract;
use Magento\Framework\Webapi\Rest\Request as RestRequest;
/**
 * Class CustomerRepositoryTest
 * @package Magestore\Webpos\Api\Customers
 */
class CustomerRepositoryTest extends WebapiAbstract
{
    const RESOURCE_PATH = '/V1/webpos/customers/';

    /**
     * Get Customer List
     */
    public function testGetList()
    {
        $requestData = [
            'searchCriteria' => [
                'current_page' => 1,
                'page_size' => 10,
                'sortOrders' => [
                    '0' => [
                        'field' => 'name',
                        'direction' => 'ASC',
                    ]
                ]
            ]
        ];

        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH . 'search?' . http_build_query($requestData) ,
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
            "The result doesn't have any item (total_count < 1)"
        );
        $keys = [
            'telephone',
            'subscriber_status',
            'full_name',
            'additional_attributes',
            'id',
            'group_id',
            'created_at',
            'updated_at',
            'email',
            'firstname',
            'lastname',
            'store_id',
            'website_id',
            'addresses',
            'disable_auto_group_change',
        ];
        foreach ($keys as $key) {
            self::assertContains(
                $key,
                array_keys($results['items'][0]),
                $key . " key is not in found in result['items'][0]'s keys"
            );
        }
    }

    /**
     * Create Customer
     */
    public function testSave() {
        $rand = mt_rand(100000, 10000000);
        $requestData = [
            'customer' => [
                'group_id' => '1',
                'lastname' => 'Thomas',
                'firstname' => 'Magestore',
                'addresses' => [],
                'email' => 'thomas'.$rand.'@gmail.com',
                'subscriber_status' => '1',
            ],
        ];

        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH . '?',
                'httpMethod' => \Magento\Framework\Webapi\Rest\Request::HTTP_METHOD_POST,
            ]
        ];

        $results = $this->_webApiCall($serviceInfo, $requestData);
        \Zend_Debug::dump($results);
        $this->assertNotNull($results);
        $keys = [
            'telephone',
            'subscriber_status',
            'full_name',
            'additional_attributes',
            'id',
            'group_id',
            'updated_at',
            'email',
            'firstname',
            'lastname',
            'store_id',
            'website_id',
            'addresses',
            'disable_auto_group_change',
        ];
        foreach ($keys as $key) {
            self::assertContains(
                $key,
                array_keys($results),
                $key . " key is not in found in result['items'][0]'s keys"
            );
        }
        self::assertEquals(
            $requestData['customer']['email'],
            $results['email'],
            'We cannot save the customre with the unique email'.$requestData['customer']['email'].''
        );
    }
}