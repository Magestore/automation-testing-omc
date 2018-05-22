<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 25/12/2017
 * Time: 13:38
 */

namespace Magento\Webpos\Api\Checkout;

use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestFramework\TestCase\WebapiAbstract;
use Magento\Framework\Webapi\Rest\Request as RestRequest;
/**
 * Class SaveQuoteDataTest
 * @package Magento\Webpos\Api\Checkout
 */
class SaveQuoteDataTest extends WebapiAbstract
{
    /**
     * const RESOURCE_PATH
     */
    const RESOURCE_PATH = '/V1/webpos/checkout/';

    /**
     * @var \Magento\Webpos\Api\Staff\LoginTest $currentSession
     */
    protected $currentSession;

    /**
     * @var \Magento\TestFramework\ObjectManager $objectManager
     */
    protected $objectManager;

    /**
     * @var \Magento\Webpos\Api\Checkout\SaveCartTest $saveCart
     */
    protected $saveCart;

    protected function setUp()
    {
        $this->objectManager = Bootstrap::getObjectManager();
        $this->currentSession = Bootstrap::getObjectManager()->create(\Magento\Webpos\Api\Staff\LoginTest::class);
        $this->saveCart = Bootstrap::getObjectManager()->create(\Magento\Webpos\Api\Checkout\SaveCartTest::class);
    }

    /**
     * API: Save Quote Data
     */
    public function callAPISaveQuoteData() {
        $session = $this->currentSession->testStaffLogin();
        $saveCart = $this->saveCart->callAPISaveCart($session);
        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH . 'saveQuoteData?session='.$session.'',
                'httpMethod' => RestRequest::HTTP_METHOD_POST,
            ]
        ];
        $requestData = [
            'customer_id'   => '',
            'quote_id'      => $saveCart['quote_init']['quote_id'],
            'quote_data'    => [
                'webpos_cart_discount_value' => '10.00',
                'webpos_cart_discount_type' => '$',
                'webpos_cart_discount_name' => ''
            ],
            'currency_id'   => 'USD',
            'till_id'   => 'null',
            'store_id'   => '1',
        ];
        $results = $this->_webApiCall($serviceInfo, $requestData);
        // Dump the result to check "How does it look like?"
        // \Zend_Debug::dump($results);
        return $results;
    }
    /**
     * API: Save Quote Data
     */
    public function testSaveQuoteData()
    {
        $results = $this->callAPISaveQuoteData();
        $this->assertNotNull($results);$this->assertNotNull($results);
        // Get the key constraint for API testSaveQuoteData. Call From Folder Constraint
        $keys = [
            'items' => [
                '0' => [
                    'item_id',
                    'quote_id',
                    'created_at',
                    'updated_at',
                    'product_id',
                    'store_id',
                    'parent_item_id',
                    'is_virtual',
                    'sku',
                    'name',
                    'description',
                    'applied_rule_ids',
                    'additional_data',
                ]
            ],
            'shipping' => [
                '0' => [
                    'code',
                    'title',
                    'description',
                    'error_message',
                    'price_type',
                ]
            ],
            'payment' => [
                '0' => [
                    'code',
                    'icon_class',
                    'title',
                    'information',
                    'type',
                ]
            ],
            'quote_init' => [
                'quote_id',
                'customer_id',
                'currency_id',
                'till_id',
                'store_id',
            ],
            'totals' => [
                '0' => [
                    'code',
                    'title',
                    'value',
                    'address',
                ]
            ],
        ];

        foreach ($keys['items'][0] as $key) {
            self::assertContains(
                $key,
                array_keys($results['items'][0]),
                $key . " key is not in found in result['items'][0]'s keys"
            );
        }
        foreach ($keys['shipping'][0] as $key) {
            self::assertContains(
                $key,
                array_keys($results['shipping'][0]),
                $key . " key is not in found in result['shipping'][0]'s keys"
            );
        }
        foreach ($keys['payment'][0] as $key) {
            self::assertContains(
                $key,
                array_keys($results['payment'][0]),
                $key . " key is not in found in result['payment'][0]'s keys"
            );
        }
        foreach ($keys['quote_init'] as $key) {
            self::assertContains(
                $key,
                array_keys($results['quote_init']),
                $key . " key is not in found in result['quote_init']'s keys"
            );
        }
        foreach ($keys['totals'][0] as $key) {
            self::assertContains(
                $key,
                array_keys($results['totals'][0]),
                $key . " key is not in found in result['totals'][0]'s keys"
            );
        }
    }
}