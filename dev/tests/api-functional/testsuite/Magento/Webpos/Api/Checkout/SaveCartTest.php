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
 * Class SaveCartTest
 * @package Magento\Webpos\Api\Checkout
 */
class SaveCartTest extends WebapiAbstract
{
    /**
     * const RESOURCE_PATH
     */
    const RESOURCE_PATH = '/V1/webpos/checkout/';

    /**
     * const CUSTOMER_RESOURCE_PATH
     */
    const CUSTOMER_RESOURCE_PATH = '/V1/webpos/customers/';

    /**
     * @var \Magento\Webpos\Api\Staff\LoginTest $currentSession
     */
    protected $currentSession;

    /**
     * @var \Magento\TestFramework\ObjectManager $objectManager
     */
    protected $objectManager;

    /**
     * @var \Magento\Webpos\Api\Checkout\PlaceOrderTest $placeOrderTest
     */
    protected $placeOrderTest;

    protected function setUp()
    {
        $this->objectManager = Bootstrap::getObjectManager();
        $this->currentSession = Bootstrap::getObjectManager()->create(\Magento\Webpos\Api\Staff\LoginTest::class);
        $this->placeOrderTest = Bootstrap::getObjectManager()->create(\Magento\Webpos\Api\Checkout\PlaceOrderTest::class);
    }

    /**
     * Call to API Save TaxClass To get quote_id
     */
    public function callAPISaveCart($session=null)
    {
        if (!$session) {
            $session = $this->currentSession->testStaffLogin();
        }
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
                    "id" => 1,
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
        return $results;
    }
    /**
     * API: Save TaxClass
     */
    public function testSaveCart() {
        $results = $this->callAPISaveCart();
        $this->assertNotNull($results);
        // Get the key constraint for API testSaveCart. Call From Folder Constraint
        $keys = [
            'items' => [
                '0' => [
                    'store_id',
                    'product_id',
                    'product_type',
                    'sku',
                    'name',
                    'weight',
                    'tax_class_id',
                    'base_cost',
                    'is_qty_decimal',
                    'quote_id',
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