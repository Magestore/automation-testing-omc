<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 25/12/2017
 * Time: 14:45
 */

namespace Magento\Webpos\Api\Customer;

use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestFramework\TestCase\WebapiAbstract;
use Magento\Framework\Webapi\Rest\Request as RestRequest;
/**
 * Class CustomerRepositoryTest
 * @package Magento\Webpos\Api\Customers
 */
class CustomerRepositoryTest extends WebapiAbstract
{
    /**
     * const RESOURCE_PATH
     */
    const RESOURCE_PATH = '/V1/webpos/customers/';

    /**
     * @var \Magento\Webpos\Api\Staff\LoginTest
     */
    protected $currentSession;

    /**
     * const SEARCH_CUSTOMER_RESOURCE_PATH
     */
    const SEARCH_CUSTOMER_RESOURCE_PATH = 'search/?searchCriteria%5Bcurrent_page%5D=1&searchCriteria%5Bpage_size%5D=10&searchCriteria%5BsortOrders%5D%5B0%5D%5Bfield%5D=name&searchCriteria%5BsortOrders%5D%5B0%5D%5Bdirection%5D=ASC&session=';

    /**
     * @var \Magento\Webpos\Api\Customer\Constraint\CustomerRepository
     */
    protected $customerRepository;

    protected function setUp()
    {
        $this->customerRepository = Bootstrap::getObjectManager()->get('\Magento\Webpos\Api\Customer\Constraint\CustomerRepository');
        $this->currentSession = Bootstrap::getObjectManager()->create(\Magento\Webpos\Api\Staff\LoginTest::class);
    }

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

        $this->assertNotNull($results);
        self::assertGreaterThanOrEqual(
            1,
            $results['total_count'],
            "The result doesn't have any item (total_count < 1)"
        );
        // Get the key constraint for API GetList. Call From Folder Constraint
        $keys = $this->customerRepository->GetList();

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
                'firstname' => 'Magento',
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
        // Get the key constraint for API Create Customer. Call From Folder Constraint
        $keys = $this->customerRepository->CreateCustomer();

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

    /**
     * test API: Search Customer
     */
    public function testSearchCustomer() {
        $session = $this->currentSession->testStaffLogin();

        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH.self::SEARCH_CUSTOMER_RESOURCE_PATH.$session,
                'httpMethod' => RestRequest::HTTP_METHOD_GET,
            ]
        ];

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

        $results = $this->_webApiCall($serviceInfo, $requestData);
        $this->assertNotNull($results);
        self::assertGreaterThanOrEqual(
            1,
            $results['total_count'],
            "The result doesn't have any item (total_count < 1)"
        );
        // Get the key constraint for API GetList. Call From Folder Constraint
        $keys = $this->customerRepository->SearchCustomer();
        foreach ($keys['key1'] as $key) {
            self::assertContains(
                $key,
                array_keys($results),
                $key . " key is not in found in result's keys"
            );
        }
        foreach ($keys['key2']['items'][0] as $key) {
            self::assertContains(
                $key,
                array_keys($results['items'][0]),
                $key . " key is not in found in result's keys"
            );
        }
        foreach ($keys['key3']['search_criteria'] as $key) {
            self::assertContains(
                $key,
                array_keys($results['search_criteria']),
                $key . " key is not in found in result['search_criteria']'s keys"
            );
        }
        foreach ($keys['key4']['search_criteria']['sort_orders'][0] as $key) {
            self::assertContains(
                $key,
                array_keys($results['search_criteria']['sort_orders'][0]),
                $key . " key is not in found in result['search_criteria']['sort_orders'][0]'s keys"
            );
        }
    }
}