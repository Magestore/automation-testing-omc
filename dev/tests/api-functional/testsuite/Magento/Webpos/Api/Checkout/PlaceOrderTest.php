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
 * Class PlaceOrderTest
 * @package Magento\Webpos\Api\Checkout
 */
class PlaceOrderTest extends WebapiAbstract
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
     * CAll API Place Order
     */
    public function callAPIPlaceOrder($session=null)
    {
        if (!$session) {
            $session = $sessionId = $this->currentSession->testStaffLogin();
        }
        $this->callAPISaveShippingMethod($session);
        $saveCart = $this->saveCart->callAPISaveCart($session);
        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH . 'placeOrder?session='.$session.'',
                'httpMethod' => RestRequest::HTTP_METHOD_POST,
            ]
        ];

        $requestData = [
            'quote_data' => [
                'customer_note' => ''
            ],
            'website_id' => '1',
            'order_comment' => 'place order comment',
            'payment' => [
                'method_data' => [
                    [
                        'amount' => 51.75,
                        'base_real_amount' => 51.75,
                        'real_amount' => 51.75,
                        'is_pay_later' => false,
                        'reference_number' => '',
                        'code' => 'cashforpos',
                        'base_amount' => 51.75,
                        'additional_data' => [],
                        'shift_id' => 'session_1519723296717',
                        'title' => 'Web POS - Cash In'
                    ]
                ],
                'method' => 'cashforpos'
            ],
            'integration' => [],
            'shipping_method' => 'flatrate_flatrate',
            'quoteId' => $saveCart['quote_init']['quote_id'],
            'extension_data' => [
                [
                    'key' => 'pos_id',
                    'value' => '5'
                ], [
                    'key' => 'grand_total',
                    'value' => 51.75
                ], [
                    'key' => 'base_grand_total',
                    'value' => 51.75
                ], [
                    'key' => 'tax_amount',
                    'value' => 6.75
                ], [
                    'key' => 'base_tax_amount',
                    'value' => 6.75
                ], [
                    'key' => 'shipping_amount',
                    'value' => 0
                ], [
                    'key' => 'base_shipping_amount',
                    'value' => 0
                ], [
                    'key' => 'subtotal',
                    'value' => 45
                ], [
                    'key' => 'base_subtotal',
                    'value' => 45
                ], [
                    'key' => 'subtotal_incl_tax',
                    'value' => 45
                ], [
                    'key' => 'base_subtotal_incl_tax',
                    'value' => 45
                ], [
                    'key' => 'webpos_staff_id',
                    'value' => '1'
                ], [
                    'key' => 'webpos_staff_name',
                    'value' => 'admin1'
                ], [
                    'key' => 'webpos_shift_id',
                    'value' => 'session_1519723296717'
                ], [
                    'key' => 'location_id',
                    'value' => '1'
                ], [
                    'key' => 'created_at',
                    'value' => ''
                ], [
                    'key' => 'customer_fullname',
                    'value' => ''
                ], [
                    'key' => 'webpos_change',
                    'value' => 0
                ], [
                    'key' => 'webpos_base_change',
                    'value' => 0
                ]
            ],
            'actions' => [
                'create_shipment' => '1',
                'create_invoice' => '1'
            ]
        ];

        $results = $this->_webApiCall($serviceInfo, $requestData);

        // Dump the result to check "How does it look like?"
        // \Zend_Debug::dump($results);
        return $results;
    }
    /**
     * Test Place Order
     */
    public function testPlaceOrder()
    {
        $results = $this->callAPIPlaceOrder();
        $this->assertNotNull($results);
        // Get the key constraint for API testPlaceOrder. Call From Folder Constraint

        $key1 = [
            'rewardpoints_earn',
            'rewardpoints_spent',
            'rewardpoints_discount',
            'rewardpoints_base_discount',
            'rewardpoints_refunded',
            'gift_voucher_discount',
            'base_gift_voucher_discount',
            'base_customercredit_discount',
            'customercredit_discount',
            'webpos_base_change',
            'webpos_change',
            'webpos_staff_id',
            'webpos_staff_name',
            'fulfill_online',
            'location_id',
            'webpos_order_payments',
            'items_info_buy',
            'items',
            'webpos_paypal_invoice_id',
            'webpos_init_data',
            'webpos_shift_id',
            'base_currency_code',
            'base_discount_amount',
            'base_discount_invoiced',
            'base_grand_total',
            'base_discount_tax_compensation_amount',
            'base_discount_tax_compensation_invoiced',
            'base_shipping_amount',
            'base_shipping_discount_amount',
            'base_subtotal',
            'store_id',
            'store_name',
            'billing_address',
            'payment',
            'status_histories',
            'extension_attributes',
        ];
        foreach ($key1 as $key) {
            self::assertContains(
                $key,
                array_keys($results),
                $key . " key is not in found in results's keys"
            );
        }

        $key2 = [
            'webpos_order_payments' => [
                '0' => [
                    'payment_id',
                    'order_id',
                    'base_payment_amount',
                    'payment_amount',
                    'base_display_amount',
                    'display_amount',
                    'method',
                    'method_title',
                    'shift_id',
                    'reference_number',
                ]
            ],
            'items_info_buy' => [
                'items' => [
                    '0' => [
                        'id',
                        'child_id',
                        'qty',
                        'super_attribute',
                        'super_group',
                        'options',
                        'bundle_option',
                        'bundle_option_qty',
                        'unit_price',
                        'base_unit_price',
                    ]
                ]
            ],
            'billing_address' => [
                'address_type',
                'city',
                'country_id',
                'email',
                'entity_id',
                'firstname',
                'lastname',
                'parent_id',
                'postcode',
                'region',
                'region_code',
                'region_id',
                'street',
                'telephone',
            ],
            'payment' => [
                'account_status',
                'additional_information',
                'amount_ordered',
                'amount_paid',
                'base_amount_ordered',
                'base_amount_paid',
                'base_shipping_amount',
                'base_shipping_captured',
                'entity_id',
                'method',
                'parent_id',
                'shipping_amount',
            ],
            'status_histories' => [
                '0' => [
                    'comment',
                    'created_at',
                    'entity_id',
                    'entity_name',
                    'is_customer_notified',
                ]
            ],
            'extension_attributes' => [
                'shipping_assignments' => [
                    '0' => [
                        'shipping' => [
                            'address' => [
                                'address_type',
                                'city',
                                'country_id',
                                'email',
                                'entity_id',
                                'firstname',
                                'lastname',
                                'parent_id',
                            ]
                        ],
                    ]
                ]
            ],
        ];
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
     * @param null $session
     *
     * Multi Place Order Test
     */
    public function testMultiPlaceOrder($session=null) {
        if (!$session) {
            $session = $sessionId = $this->currentSession->testStaffLogin();
        }
        $this->callAPISaveShippingMethod();
        $this->saveCart->callAPISaveCart($session);
        $this->callAPISaveShippingMethod();
        $this->callAPISaveShippingMethod();
        $this->callAPISaveShippingMethod();
        $this->callAPISaveShippingMethod();
        $this->testPlaceOrder();
    }
}