<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 25/12/2017
 * Time: 13:38
 */

namespace Magestore\Webpos\Api\Cart;

use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestFramework\TestCase\WebapiAbstract;
use Magento\Framework\Webapi\Rest\Request as RestRequest;
/**
 * Class CheckoutTest
 * @package Magestore\Webpos\Api\TaxClass
 */
class CheckoutTest extends WebapiAbstract
{
    const RESOURCE_PATH = '/V1/webpos/checkout/';
    const APPLY_GIFTCARD_RESOURCE_PATH = '/V1/webpos/integration/applyGiftcard';
    const SPEND_POINT_RESOURCE_PATH = '/V1/webpos/integration/spendPoint';

    /**
     * @var \Magento\TestFramework\ObjectManager
     */
    protected $objectManager;

    /**
     * @var \Magestore\Webpos\Api\Cart\Constraint\Checkout
     */
    protected $checkout;

    /**
     * @var \Magestore\Webpos\Api\CurrentSessionId\CurrentSessionIdTest
     */
    protected $currentSession;

    protected function setUp()
    {
        $this->objectManager = Bootstrap::getObjectManager();
        $this->currentSession = $this->objectManager->get('\Magestore\Webpos\Api\CurrentSessionId\CurrentSessionIdTest');
        $this->checkout = $this->objectManager->get('\Magestore\Webpos\Api\Cart\Constraint\Checkout');
    }

    /**
     * Call to API Save TaxClass To get quote_id
     */
    protected function callAPISaveCart()
    {
        $session = $this->currentSession->getCurrentSessionId();
        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH . 'saveCart?session='.$session.'',
                'httpMethod' => RestRequest::HTTP_METHOD_POST,
            ]
        ];

        $itemId = mt_rand(10000000000000, 100000000000000);

        $requestData = [
            "quote_id" => "",
            "store_id" => "1",
            "customer_id" => "",
            "currency_id" => "USD",
            "till_id" => "",
            "items" => [
                [
                    "id" => 6,
                    "item_id" => $itemId,
                    "qty" => 1,
                    "qty_to_ship" => 0,
                    "use_discount" => 1,
                    "extension_data" => [
                        [
                            "key" => "row_total",
                            "value" => 59
                        ],
                        [
                            "key" => "base_row_total",
                            "value" => 59
                        ],
                        [
                            "key" => "row_total_incl_tax",
                            "value" => 59
                        ],
                        [
                            "key" => "base_row_total_incl_tax",
                            "value" => 59
                        ],
                        [
                            "key" => "price",
                            "value" => 59
                        ],
                        [
                            "key" => "base_price",
                            "value" => 59
                        ],
                        [
                            "key" => "price_incl_tax",
                            "value" => 59
                        ],
                        [
                            "key" => "base_price_incl_tax",
                            "value" => 59
                        ],
                        [
                            "key" => "discount_amount",
                            "value" => 0
                        ],
                        [
                            "key" => "base_discount_amount",
                            "value" => 0
                        ],
                        [
                            "key" => "tax_amount",
                            "value" => 0
                        ],
                        [
                            "key" => "base_tax_amount",
                            "value" => 0
                        ],
                        [
                            "key" => "custom_tax_class_id",
                            "value" => 2
                        ],
                        [
                            "key" => "discount_tax_compensation_amount",
                            "value" => 0
                        ],
                        [
                            "key" => "base_discount_tax_compensation_amount",
                            "value" => 0
                        ],
                        [
                            "key" => "customercredit_discount",
                            "value" => 0
                        ],
                        [
                            "key" => "base_customercredit_discount",
                            "value" => 0
                        ],
                        [
                            "key" => "rewardpoints_earn",
                            "value" => 0
                        ],
                        [
                            "key" => "rewardpoints_spent",
                            "value" => 0
                        ],
                        [
                            "key" => "rewardpoints_discount",
                            "value" => 0
                        ],
                        [
                            "key" => "rewardpoints_base_discount",
                            "value" => 0
                        ],
                        [
                            "key" => "gift_voucher_discount",
                            "value" => 0
                        ],
                        [
                            "key" => "base_gift_voucher_discount",
                            "value" => 0
                        ]
                    ],
                    "amount" => 59,
                    "credit_price_amount" => 'null',
                    "options" => [
                        [
                            "code" => "credit_price_amount",
                            "value" => 'null'
                        ],
                        [
                            "code" => "amount",
                            "value" => 59
                        ],
                        [
                            "code" => "amount",
                            "value" => 59
                        ],
                        [
                            "code" => "giftcard_template_image",
                            "value" => ""
                        ],
                        [
                            "code" => "giftcard_template_id",
                            "value" => ""
                        ],
                        [
                            "code" => "message",
                            "value" => ""
                        ],
                        [
                            "code" => "recipient_name",
                            "value" => ""
                        ],
                        [
                            "code" => "send_friend",
                            "value" => ""
                        ],
                        [
                            "code" => "recipient_ship",
                            "value" => ""
                        ],
                        [
                            "code" => "recipient_email",
                            "value" => ""
                        ],
                        [
                            "code" => "day_to_send",
                            "value" => ""
                        ],
                        [
                            "code" => "timezone_to_send",
                            "value" => ""
                        ],
                        [
                            "code" => "recipient_address",
                            "value" => ""
                        ],
                        [
                            "code" => "notify_success",
                            "value" => ""
                        ]
                    ],
                    "giftcard_template_id" => "",
                    "giftcard_template_image" => "",
                    "message" => "",
                    "recipient_name" => "",
                    "send_friend" => "",
                    "recipient_ship" => "",
                    "recipient_email" => "",
                    "day_to_send" => "",
                    "timezone_to_send" => "",
                    "recipient_address" => "",
                    "notify_success" => ""
                ]
            ],
            "customer" => [
                "customer_id" => "",
                "billing_address" => [
                    "country_id" => "US",
                    "postcode" => "90034",
                    "region" => [
                        "region" => "California",
                        "region_id" => 12,
                        "region_code" => "CA"
                    ],
                    "region_id" => 12,
                    "city" => "Guest City",
                    "email" => "guest@example.com",
                    "firstname" => "Guest",
                    "lastname" => "POS",
                    "street" => [
                        "Street"
                    ],
                    "telephone" => "12345678"
                ],
                "shipping_address" => [
                    "country_id" => "US",
                    "postcode" => "90034",
                    "region" => [
                        "region" => "California",
                        "region_id" => 12,
                        "region_code" => "CA"
                    ],
                    "region_id" => 12,
                    "city" => "Guest City",
                    "email" => "guest@example.com",
                    "firstname" => "Guest",
                    "lastname" => "POS",
                    "street" => [
                        "Street"
                    ],
                    "telephone" => "12345678"
                ]
            ]
        ];

        $results = $this->_webApiCall($serviceInfo, $requestData);
        // Dump the result to check "How does it look like?"
        // \Zend_Debug::dump($results);
        return $results;
    }

    /**
     * API: Save TaxClass
     */
    public function testSaveCart() {
        $results = $this->callAPISaveCart();
        $this->assertNotNull($results);
        // Get the key constraint for API testSaveCart. Call From Folder Constraint
        $keys = $this->checkout->SaveCart();

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

    /**
     * API: Save Quote Data
     */
    public function testSaveQuoteData()
    {
        $session = $this->currentSession->getCurrentSessionId();
        $saveCart = $this->callAPISaveCart();
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

        $this->assertNotNull($results);$this->assertNotNull($results);
        // Get the key constraint for API testSaveQuoteData. Call From Folder Constraint
        $keys = $this->checkout->SaveQuoteData();

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

    /**
     * Save Shipping Method
     */
    public function testSaveShippingMethod()
    {
        $session = $this->currentSession->getCurrentSessionId();
        $saveCart = $this->callAPISaveCart();
        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH . 'saveShippingMethod?session='.$session.'',
                'httpMethod' => RestRequest::HTTP_METHOD_POST,
            ]
        ];

        $requestData = [
            'quote_id'      => $saveCart['quote_init']['quote_id'],
            'shipping_method' => 'webpos_shipping_storepickup'
        ];

        $results = $this->_webApiCall($serviceInfo, $requestData);

        // Dump the result to check "How does it look like?"
        // \Zend_Debug::dump($results);

        $this->assertNotNull($results);$this->assertNotNull($results);
        // Get the key constraint for API testSaveShippingMethod. Call From Folder Constraint
        $keys = $this->checkout->SaveShippingMethod();

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
    }

    /**
     * Place Order
     */
    public function testPlaceOrder()
    {
        $session = $this->currentSession->getCurrentSessionId();
        $saveCart = $this->callAPISaveCart();
        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH . 'placeOrder?session='.$session.'',
                'httpMethod' => RestRequest::HTTP_METHOD_POST,
            ]
        ];

        $requestData = [
            'quote_id' => $saveCart['quote_init']['quote_id'],
            'payment' => [
                'method' => 'cashforpos',
                'method_data' => [
                    [
                        'code' => 'cashforpos',
                        'title' => 'Web POS - Cash In',
                        'base_amount' => 59,
                        'amount' => 59,
                        'base_real_amount' => 59,
                        'real_amount' => 59,
                        'is_pay_later' => '0',
                        'shift_id' => 'session_1514250244118',
                        'additional_data' => [
                        ]
                    ]
                ]
            ],
            'shipping_method' => 'webpos_shipping_storepickup',
            'quote_data' => [
                'webpos_cart_discount_name' => '',
                'webpos_cart_discount_type' => '$',
                'webpos_cart_discount_value' => '',
                'customer_note' => '',
                'is_web_version' => 1
            ],
            'actions' => [
                'create_invoice' => true,
                'create_shipment' => false,
                'delivery_time' => ''
            ],
            'integration' => [

            ],
            'extension_data' => [
                [
                    'key' => 'webpos_staff_id',
                    'value' => '1'
                ],
                [
                    'key' => 'webpos_staff_name',
                    'value' => 'magentoadmin magentoadmin'
                ],
                [
                    'key' => 'webpos_shift_id',
                    'value' => 'session_1514250244118'
                ],
                [
                    'key' => 'fulfill_online',
                    'value' => 1
                ],
                [
                    'key' => 'location_id',
                    'value' => '1'
                ]
            ]
        ];

        $results = $this->_webApiCall($serviceInfo, $requestData);

        // Dump the result to check "How does it look like?"
        // \Zend_Debug::dump($results);

        $this->assertNotNull($results);
        // Get the key constraint for API testPlaceOrder. Call From Folder Constraint
        $keys = $this->checkout->PlaceOrder();

        $key1 = $keys['key1'];
        foreach ($key1 as $key) {
            self::assertContains(
                $key,
                array_keys($results),
                $key . " key is not in found in results's keys"
            );
        }

        $key2 = $keys['key2'];
        foreach ($key2['webpos_order_payments'][0] as $key) {
            self::assertContains(
                $key,
                array_keys($results['webpos_order_payments'][0]),
                $key . " key is not in found in result['items'][0]'s keys"
            );
        }
        foreach ($key2['items_info_buy']['items'][0] as $key) {
            self::assertContains(
                $key,
                array_keys($results['items_info_buy']['items'][0]),
                $key . " key is not in found in results['items_info_buy']['items'][0]'s keys"
            );
        }
        foreach ($key2['items'][0] as $key) {
            self::assertContains(
                $key,
                array_keys($results['items'][0]),
                $key . " key is not in found in results['items'][0]'s keys"
            );
        }
        foreach ($key2['billing_address'] as $key) {
            self::assertContains(
                $key,
                array_keys($results['billing_address']),
                $key . " key is not in found in result['billing_address']'s keys"
            );
        }
        foreach ($key2['payment'] as $key) {
            self::assertContains(
                $key,
                array_keys($results['payment']),
                $key . " key is not in found in result['payment']'s keys"
            );
        }
        foreach ($key2['status_histories'][0] as $key) {
            self::assertContains(
                $key,
                array_keys($results['status_histories'][0]),
                $key . " key is not in found in result['status_histories'][0]'s keys"
            );
        }
        foreach ($key2['extension_attributes']['shipping_assignments'][0]['shipping']['address'] as $key) {
            self::assertContains(
                $key,
                array_keys($results['extension_attributes']['shipping_assignments'][0]['shipping']['address']),
                $key . " key is not in found in result['extension_attributes']['shipping_assignments'][0]['shipping']['address']'s keys"
            );
        }
    }

    /**
     * We need an API Create Giftcard before do this API
     * Apply Giftcard
     */
    public function testApplyGiftcard()
    {
        $session = $this->currentSession->getCurrentSessionId();
        $saveCart = $this->callAPISaveCart();
        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::APPLY_GIFTCARD_RESOURCE_PATH . '?session='.$session.'',
                'httpMethod' => RestRequest::HTTP_METHOD_POST,
            ]
        ];

        $requestData = [
            'quote_id' => $saveCart['quote_init']['quote_id'],
            'amount' => '',
            'code' => 'ABCDEFGH',
        ];

        $results = $this->_webApiCall($serviceInfo, $requestData);

        // Dump the result to check "How does it look like?"
        // \Zend_Debug::dump($results);

        $this->assertNotNull($results);
    }

    /**
     * Spend RWP
     */
    public function testSpendPoint()
    {
        $session = $this->currentSession->getCurrentSessionId();
        $saveCart = $this->callAPISaveCart();
        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::SPEND_POINT_RESOURCE_PATH . '?session='.$session.'',
                'httpMethod' => RestRequest::HTTP_METHOD_POST,
            ]
        ];

        $requestData = [
            'quote_id' => $saveCart['quote_init']['quote_id'],
            'rule_id' => 'rate',
            'used_point' => '1000',
        ];

        $results = $this->_webApiCall($serviceInfo, $requestData);

        // Dump the result to check "How does it look like?"
        // \Zend_Debug::dump($results);

        $this->assertNotNull($results);
        // Get the key constraint for API testSpendPoint. Call From Folder Constraint
        $keys = $this->checkout->SpendPoint();

        $key1 = $keys['key1'];
        foreach ($key1 as $key) {
            self::assertContains(
                $key,
                array_keys($results),
                $key . " key is not in found in results's keys"
            );
        }

        $key2 = $keys['key2'];
        foreach ($key2['items'][0] as $key) {
            self::assertContains(
                $key,
                array_keys($results['items'][0]),
                $key . " key is not in found in results['items'][0]'s keys"
            );
        }
        foreach ($key2['shipping'][0] as $key) {
            self::assertContains(
                $key,
                array_keys($results['shipping'][0]),
                $key . " key is not in found in results['shipping'][0]'s keys"
            );
        }
        foreach ($key2['payment'][0] as $key) {
            self::assertContains(
                $key,
                array_keys($results['payment'][0]),
                $key . " key is not in found in results['payment'][0]'s keys"
            );
        }
        foreach ($key2['quote_init'] as $key) {
            self::assertContains(
                $key,
                array_keys($results['quote_init']),
                $key . " key is not in found in results['payment'][0]'s keys"
            );
        }
        foreach ($key2['totals'][0] as $key) {
            self::assertContains(
                $key,
                array_keys($results['totals'][0]),
                $key . " key is not in found in results['totals'][0]'s keys"
            );
        }
        foreach ($key2['giftcard'] as $key) {
            self::assertContains(
                $key,
                array_keys($results['giftcard']),
                $key . " key is not in found in results['giftcard']'s keys"
            );
        }
        foreach ($key2['rewardpoints'] as $key) {
            self::assertContains(
                $key,
                array_keys($results['rewardpoints']),
                $key . " key is not in found in results['rewardpoints']'s keys"
            );
        }
    }
}