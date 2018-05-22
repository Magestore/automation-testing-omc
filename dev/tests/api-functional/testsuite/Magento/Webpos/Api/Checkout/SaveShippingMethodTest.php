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
 * Class SaveShippingMethodTest
 * @package Magento\Webpos\Api\Checkout
 */
class SaveShippingMethodTest extends WebapiAbstract
{
    /**
     * const RESOURCE_PATH
     */
    const RESOURCE_PATH = '/V1/webpos/checkout/';

    /**
     * const APPLY_GIFTCARD_RESOURCE_PATH
     */
    const APPLY_GIFTCARD_RESOURCE_PATH = '/V1/webpos/integration/applyGiftcard';

    /**
     * const SPEND_POINT_RESOURCE_PATH
     */
    const SPEND_POINT_RESOURCE_PATH = '/V1/webpos/integration/spendPoint';

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
     * Call API Save Shipping Method
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
        return [
            'results' => $results,
            'saveCart' => $saveCart,
        ];
    }

    /**
     * test API Save Shipping Method
     */
    public function testSaveShippingMethod()
    {
        $data = $this->callAPISaveShippingMethod();
        $results = $data['results'];

        $this->assertNotNull($results);$this->assertNotNull($results);
        // Get the key constraint for API testSaveShippingMethod. Call From Folder Constraint
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
                    'is_qty_decimal',
                    'no_discount',
                    'weight',
                    'qty',
                    'price',
                    'base_price',
                    'custom_price',
                ]
            ],
            'shipping' => [],
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
        return $results;
    }
}