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
 * Class RemoveItemTest
 * @package Magento\Webpos\Api\Checkout
 */
class RemoveItemTest extends WebapiAbstract
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

    /**
     * @var \Magento\Webpos\Api\Checkout\PlaceOrderTest $placeOrderTest
     */
    protected $placeOrderTest;

    protected function setUp()
    {
        $this->objectManager = Bootstrap::getObjectManager();
        $this->currentSession = Bootstrap::getObjectManager()->create(\Magento\Webpos\Api\Staff\LoginTest::class);
        $this->saveCart = Bootstrap::getObjectManager()->create(\Magento\Webpos\Api\Checkout\SaveCartTest::class);
        $this->placeOrderTest = Bootstrap::getObjectManager()->create(\Magento\Webpos\Api\Checkout\PlaceOrderTest::class);
    }

    /**
     * Save Shipping Method
     */
    public function callAPISaveShippingMethod($session=null) {
        if (!$session) {
            $session = $sessionId = $this->currentSession->testStaffLogin();
        }
        $saveCart = $this->saveCart->callAPISaveCart($session);
        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH . 'saveShippingMethod?session='.$session.'',
                'httpMethod' => RestRequest::HTTP_METHOD_POST,
            ]
        ];

        $requestData = [
            'quote_id'      => $saveCart['quote_init']['quote_id'],
            'shipping_method' => 'webpos_shipping_storepickup',
            'website_id' => '1'
        ];

        $results = $this->_webApiCall($serviceInfo, $requestData);
        return $results;
    }
    /**
     * API Remove Item
     */
    public function callAPIRemoveItem($session=null)
    {
        if(!$session) {
            $session = $sessionId = $this->currentSession->testStaffLogin();
        }
        $saveCart = $this->saveCart->callAPISaveCart($session);
        $quoteId = $saveCart['quote_init']['quote_id'];
        $itemId = $saveCart['items']['0']['item_id'];
        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH . 'removeItem?session='.$session.'&item_id='.$itemId.'&quote_id='.$quoteId.'&website_id=1',
                'httpMethod' => RestRequest::HTTP_METHOD_DELETE,
            ]
        ];
        $results = $this->_webApiCall($serviceInfo);
        return $results;
    }
    /**
     * API Remove Item
     */
    public function testRemoveItem()
    {
        $results = $this->callAPIRemoveItem();
        $this->assertNotNull($results);
        // Get the key constraint for API testPlaceOrder. Call From Folder Constraint

        $key1 = [
            'items',
            'shipping',
            'payment',
            'quote_init',
            'totals',
            'giftcard',
            'rewardpoints',
            'storecredit'
        ];
        foreach ($key1 as $key) {
            self::assertContains(
                $key,
                array_keys($results),
                $key . " key is not in found in results's keys"
            );
        }

        $key2 = [
            'quote_init' => [
                'customer_id',
                'quote_id',
                'currency_id',
                'till_id',
                'store_id'
            ],
            'totals' => [
                'code',
                'title',
                'value',
                'address'
            ]
        ];

        $key3 = [
            'totals' => [
                'address' => [
                    '_objectCopyService',
                    '_carrierFactory',
                ]
            ]
        ];
        foreach ($key2['quote_init'] as $key) {
            self::assertContains(
                $key,
                array_keys($results['quote_init']),
                $key . " key is not in found in result['quote_init'][0]'s keys"
            );
        }
        foreach ($key2['totals'] as $key) {
            self::assertContains(
                $key,
                array_keys($results['totals'][0]),
                $key . " key is not in found in results['totals'][0]'s keys"
            );
        }
        foreach ($key3['totals']['address'] as $key) {
            self::assertContains(
                $key,
                array_keys($results['totals'][0]['address']),
                $key . " key is not in found in results['totals'][0]['address']'s keys"
            );
        }
    }
}