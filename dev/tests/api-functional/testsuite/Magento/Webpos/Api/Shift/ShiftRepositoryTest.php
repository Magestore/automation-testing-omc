<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 25/12/2017
 * Time: 12:58
 */

namespace Magento\Webpos\Api\Shift;

use Magento\TestFramework\TestCase\WebapiAbstract;
use Magento\Framework\Webapi\Rest\Request as RestRequest;
use Magento\TestFramework\Helper\Bootstrap;
use Magento\Store\Model\ScopeInterface;
/**
 * Class ShiftRepositoryTest
 * @package Magento\AutoTestWebposToaster\Api\Shift
 */
class ShiftRepositoryTest extends WebapiAbstract
{
    const RESOURCE_PATH = '/V1/webpos/shifts/';

    /**
     * @var \Magento\Webpos\Api\Shift\Constraint\ShiftRepository
     */
    protected $shiftRepository;

    /**
     * Configuration: Sales -> Web POS -> Settings ->
     * -> General Configuration -> Need to create session before working to Yes
     */
    protected function setUp()
    {
        $objectManager = Bootstrap::getObjectManager();
        $this->shiftRepository = $objectManager->get('\Magento\Webpos\Api\Shift\Constraint\ShiftRepository');

        $configResource = $objectManager->get(\Magento\Config\Model\ResourceModel\Config::class);
        $configResource->saveConfig(
            'webpos/general/enable_session',
            '1',
            ScopeInterface::SCOPE_DEFAULT,
            0
        );
    }

    /**
     * API Name: Get List Session
     */
    public function testGetList()
    {
        $requestData = [
            'searchCriteria' => [
                'filter_groups' => [
                    '0' => [
                        'filters' => [
                            '0' => [
                                'field' => 'pos_id',
                                'value' => '1',
                                'condition_type' => 'eq'
                            ]
                        ]
                    ]
                ],
                'pageSize' => 1,
                'currentPage' => 1,
                'sort_orders' => [
                    '0' => [
                        'field' => 'entity_id',
                        'direction' => 'DESC'
                    ]
                ]
            ]
        ];

        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH . 'getlist?' . http_build_query($requestData) ,
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
        // Get the key constraint for API Get List Session. Call From Folder Constraint
        $keys = $this->shiftRepository->GetList();

        foreach ($keys as $key) {
            self::assertContains(
                $key,
                array_keys($results['items'][0]),
                $key . " key is not in found in result['items'][0]'s keys"
            );
        }
    }

    /**
     * Action to close the session
     */
    public function closeSession()
    {
        $session = $this->openSession();
        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH . 'save?',
                'httpMethod' => RestRequest::HTTP_METHOD_POST,
            ]
        ];

        $requestData = [
            'shift' => [
                'cash_added' => 50,
                'opened_note' => 'null',
                'base_cash_removed' => 20,
                'entity_id' => 1,
                'status' => 2,
                'cash_sale' => 168.87,
                'staff_id' => 1,
                'base_cash_sale' => 168.87,
                'base_float_amount' => 0,
                'base_cash_left' => 198.87,
                'float_amount' => 0,
                'balance' => 198.87,
                'location_id' => 1,
                'base_total_sales' => 258.87,
                'cash_left' => 198.87,
                'total_sales' => 258.87,
                'closed_note' => 'null',
                'closed_at' => '2017-12-18 09:40:31',
                'base_closed_amount' => 198.87,
                'cash_removed' => 20,
                'closed_amount' => 198.87,
                'base_cash_added' => 50,
                'shift_id' => $session[0]['shift_id'],
                'base_balance' => 198.87,
                'shift_currency_code' => 'USD',
                'base_currency_code' => 'USD'
            ]
        ];

        $results = $this->_webApiCall($serviceInfo, $requestData);

        // Dump the result to check "How does it look like?"
        // \Zend_Debug::dump($results);

        return $results;
    }

    /**
     * Close Session
     */
    public function testSave()
    {
        $results = $this->closeSession();

        $this->assertNotNull($results);
        // Get the key constraint for API Close Session. Call From Folder Constraint
        $keys = $this->shiftRepository->Save();

        $key1 = $keys['key1'];
        foreach ($key1 as $key) {
            self::assertContains(
                $key,
                array_keys($results),
                $key . " key is not in found in result['items'][0]'s keys"
            );
        }

        $key2 = $keys['key2'];
        foreach ($key2['0']['zreport_sales_summary'] as $key) {
            self::assertContains(
                $key,
                array_keys($results['0']['zreport_sales_summary']),
                $key . " key is not in found in results['0']['zreport_sales_summary']'s keys"
            );
        }
    }

    /**
     * We need to setup the 'Create session before working in Store->Configuration and
     * Login to open session' for creating the session
     * Validate Session
     */
    public function testValidateSession()
    {
        $session = $this->openSession();

        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH . 'save?',
                'httpMethod' => RestRequest::HTTP_METHOD_POST,
            ]
        ];

        $requestData = [
            'shift' => [
                'cash_added' => 50,
                'opened_note' => 'null',
                'base_cash_removed' => 20,
                'entity_id' => 3,
                'status' => 1,
                'cash_sale' => 168.87,
                'staff_id' => '1',
                'base_cash_sale' => 168.87,
                'base_float_amount' => 0,
                'base_cash_left' => 198.87,
                'float_amount' => 0,
                'balance' => 0,
                'location_id' => 1,
                'base_total_sales' => 258.87,
                'cash_left' => 198.87,
                'total_sales' => 258.87,
                'closed_note' => 'null',
                'closed_at' => '2017-12-18 09:41:29',
                'base_closed_amount' => 198.87,
                'cash_removed' => 20,
                'closed_amount' => 198.87,
                'base_cash_added' => 50,
                'pos_id' => $session[0]['pos_id'],
                'shift_id' => $session[0]['shift_id'],
                'base_balance' => 0,
                'shift_currency_code' => 'USD',
                'base_currency_code' => 'USD'
            ]
        ];

        $results = $this->_webApiCall($serviceInfo, $requestData);

        // Dump the result to check "How does it look like?"
        // \Zend_Debug::dump($results);

        $this->assertNotNull($results);
        // Get the key constraint for API Close Session. Call From Folder Constraint
        $keys = $this->shiftRepository->ValidateSession();

        $key1 = $keys['key1'];
        foreach ($key1 as $key) {
            self::assertContains(
                $key,
                array_keys($results),
                $key . " key is not in found in result['items'][0]'s keys"
            );
        }

        $key2 = $keys['key2'];
        foreach ($key2[0]['zreport_sales_summary'] as $key) {
            self::assertContains(
                $key,
                array_keys($results[0]['zreport_sales_summary']),
                $key . " key is not in found in results[0]['sale_summary'][0]'s keys"
            );
        }
    }

    /**
     * We need to setup the 'Create session before working in Store->Configuration and
     * Login to open session' for creating the session
     * Open Session
     */
    public function openSession()
    {
        $shift_id = mt_rand(1000000000000,10000000000000);
        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH . 'save?',
                'httpMethod' => RestRequest::HTTP_METHOD_POST,
            ]
        ];

        $requestData = [
            'shift' => [
                'opened_at' => '2017-12-18 09:45:07',
                'opened_note' => '',
                'base_currency_code' => 'USD',
                'status' => 0,
                'base_cash_removed' => 0,
                'cash_sale' => 0,
                'staff_id' => '1',
                'base_cash_sale' => 0,
                'base_float_amount' => 150,
                'base_cash_left' => 0,
                'float_amount' => 150,
                'balance' => 150,
                'location_id' => 1,
                'total_sales' => 0,
                'cash_left' => 0,
                'base_closed_amount' => 0,
                'closed_note' => '',
                'base_total_sales' => 0,
                'cash_removed' => 0,
                'closed_amount' => 0,
                'base_cash_added' => 150,
                'pos_id' => '1',
                'shift_id' => 'session_'.$shift_id.'',
                'base_balance' => 150,
                'shift_currency_code' => 'USD',
                'cash_added' => 150
            ]
        ];

        $results = $this->_webApiCall($serviceInfo, $requestData);

        // Dump the result to check "How does it look like?"
        // \Zend_Debug::dump($results);

        return $results;
    }

    /**
     * We need to setup the 'Create session before working in Store->Configuration and
     * Login to open session' for creating the session
     * Open Session
     */
    public function testOpenSession()
    {
        $results = $this->openSession();
        $this->assertNotNull($results);
        // Get the key constraint for API Close Session. Call From Folder Constraint
        $keys = $this->shiftRepository->OpenSession();

        $key1 = $keys['key1'];
        foreach ($key1 as $key) {
            self::assertContains(
                $key,
                array_keys($results),
                $key . " key is not in found in result['items'][0]'s keys"
            );
        }

        $key2 = $keys['key2'];
        foreach ($key2[0]['zreport_sales_summary'] as $key) {
            self::assertContains(
                $key,
                array_keys($results[0]['zreport_sales_summary']),
                $key . " key is not in found in results[0]['sale_summary'][0]'s keys"
            );
        }
    }

    /**
     * Configuration: Sales -> Web POS -> Settings ->
     * -> General Configuration -> Need to create session before working to No
     */
    public function tearDown()
    {
        $objectManager = Bootstrap::getObjectManager();
        $configResource = $objectManager->get(\Magento\Config\Model\ResourceModel\Config::class);
        $configResource->saveConfig(
            'webpos/general/enable_session',
            '0',
            ScopeInterface::SCOPE_DEFAULT,
            0
        );
    }
}