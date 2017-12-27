<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 25/12/2017
 * Time: 14:59
 */

namespace Magestore\Webpos\Api\Sales;

use Magento\TestFramework\TestCase\WebapiAbstract;
use Magento\Framework\Webapi\Rest\Request as RestRequest;
/**
 * Class OrderRepositoryTest
 * @package Magestore\Webpos\Api\Sales
 */
class OrderRepositoryTest extends WebapiAbstract
{
    const RESOURCE_PATH = '/V1/webpos/orders/';

    /**
     * Get List Order
     */
    public function testGetList()
    {
        $requestData = [
            'searchCriteria' => [
                'current_page' => 1,
                'page_size' => 10,
                'sortOrders' => [
                    '0' => [
                        'field' => 'created_at',
                        'direction' => 'DESC',
                    ]
                ]
            ]
        ];

        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH . '?' . http_build_query($requestData) ,
                'httpMethod' => RestRequest::HTTP_METHOD_GET,
            ]
        ];

        $results = $this->_webApiCall($serviceInfo, $requestData);

        // Dump the result to check "How does it look like?"
//         \Zend_Debug::dump($results);

        $this->assertNotNull($results);
        $this->assertGreaterThanOrEqual(
            '1',
            $results['total_count'],
            'The results doesn\'t have items.'
        );
        $key1 = [
            'items' => [
                '0' => [
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
                    'webpos_init_data',
                    'applied_rule_ids',
                    'billing_address',
                    'payment',
                    'status_histories',
                    'extension_attributes',
                    'billing_address',
                ]
            ]
        ];
        foreach ($key1['items'][0] as $key) {
            self::assertContains(
                $key,
                array_keys($results['items'][0]),
                $key . " key is not in found in result['items'][0]'s keys"
            );
        }
        $key2 = [
            'items' => [
                '0' => [
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
                    'items' => [
                        '0' => [
                            'rewardpoints_earn',
                            'rewardpoints_spent',
                            'rewardpoints_discount',
                            'rewardpoints_base_discount',
                            'gift_voucher_discount',
                            'base_gift_voucher_discount',
                            'amount_refunded',
                            'applied_rule_ids',
                            'base_amount_refunded',
                            'base_discount_amount',
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
                    ],
                    'status_histories' => [
                        '0' => [
                            'comment',
                            'created_at',
                            'entity_id',
                            'entity_name',
                            'is_customer_notified',
                            'is_visible_on_front',
                            'parent_id',
                            'status',
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
                                        'postcode',
                                        'region',
                                        'region_code',
                                        'region_id',
                                        'street',
                                        'telephone',
                                    ],
                                    'total' => [
                                        'base_shipping_amount',
                                        'base_shipping_discount_amount',
                                        'base_shipping_incl_tax',
                                        'base_shipping_invoiced',
                                        'base_shipping_tax_amount',
                                        'shipping_amount',
                                        'shipping_discount_amount',
                                        'shipping_discount_tax_compensation_amount',
                                        'shipping_incl_tax',
                                        'shipping_invoiced',
                                        'shipping_tax_amount',
                                    ],
                                ],
                            ]
                        ]
                    ],
                ]
            ]
        ];
        foreach ($key2['items'][0]['webpos_order_payments'][0] as $key) {
            self::assertContains(
                $key,
                array_keys($results['items'][0]['webpos_order_payments'][0]),
                $key . " key is not in found in results['items'][0]['webpos_order_payments'][0]'s keys"
            );
        }
        foreach ($key2['items'][0]['items_info_buy']['items'][0] as $key) {
            self::assertContains(
                $key,
                array_keys($results['items'][0]['items_info_buy']['items'][0]),
                $key . " key is not in found in results['items'][0]['items_info_buy']['items'][0]'s keys"
            );
        }
        foreach ($key2['items'][0]['items'][0] as $key) {
            self::assertContains(
                $key,
                array_keys($results['items'][0]['items'][0]),
                $key . " key is not in found in results['items'][0['items'][0]'s keys"
            );
        }
        foreach ($key2['items'][0]['billing_address'] as $key) {
            self::assertContains(
                $key,
                array_keys($results['items'][0]['billing_address']),
                $key . " key is not in found in results['items'][0]['billing_address']'s keys"
            );
        }
        foreach ($key2['items'][0]['payment'] as $key) {
            self::assertContains(
                $key,
                array_keys($results['items'][0]['payment']),
                $key . " key is not in found in results['items'][0]['payment']'s keys"
            );
        }
        foreach ($key2['items'][0]['status_histories'][0] as $key) {
            self::assertContains(
                $key,
                array_keys($results['items'][0]['status_histories'][0]),
                $key . " key is not in found in results['items'][0]['status_histories'][0]'s keys"
            );
        }
        foreach ($key2['items'][0]['extension_attributes']['shipping_assignments'][0]['shipping']['address'] as $key) {
            self::assertContains(
                $key,
                array_keys($results['items'][0]['extension_attributes']['shipping_assignments'][0]['shipping']['address']),
                $key . " key is not in found in results['items'][0]['extension_attributes']['shipping_assignments'][0]['shipping']['address']'s keys"
            );
        }
        foreach ($key2['items'][0]['extension_attributes']['shipping_assignments'][0]['shipping']['total'] as $key) {
            self::assertContains(
                $key,
                array_keys($results['items'][0]['extension_attributes']['shipping_assignments'][0]['shipping']['total']),
                $key . " key is not in found in results['items'][0]['extension_attributes']['shipping_assignments'][0]['shipping']['total']'s keys"
            );
        }
    }

    /**
     * Order add comment
     */
    public function testAddComment()
    {
        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH . '16/comments/?',
                'httpMethod' => RestRequest::HTTP_METHOD_POST,
            ]
        ];

        $requestData = [
            'statusHistory' => [
                'parentId' => '16',
                'comment' => 'Test add comment\n',
                'isVisibleOnFront' => '1',
                'entityName' => 'string',
                'createdAt' => '2017-12-19 10:44:12.782'
            ]
        ];

        $results = $this->_webApiCall($serviceInfo, $requestData);

        // Dump the result to check "How does it look like?"
//         \Zend_Debug::dump($results);


        $this->assertNotNull($results);
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
        ];
        foreach ($key1 as $key) {
            self::assertContains(
                $key,
                array_keys($results),
                $key . " key is not in found in result['items'][0]'s keys"
            );
        }
        $key2 = [
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
                        'original_price',
                        'base_original_price',
                        'options_label',
                        'custom_sales_info',
                    ]
                ],
            ],
            'items' => [
                '0' => [
                    'customercredit_discount',
                    'base_customercredit_discount',
                    'rewardpoints_earn',
                    'rewardpoints_spent',
                    'rewardpoints_discount',
                    'rewardpoints_base_discount',
                    'gift_voucher_discount',
                    'amount_refunded',
                    'base_amount_refunded',
                    'base_discount_amount',
                    'base_discount_invoiced',
                    'base_discount_tax_compensation_amount',
                    'base_original_price',
                    'base_price',
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
            ],
            'payment' => [
                'account_status',
                'additional_information',
                'amount_ordered',
                'base_amount_ordered',
                'base_shipping_amount',
                'base_shipping_amount',
            ],
            'status_histories' => [
                '0' => [
                    'comment',
                    'created_at',
                    'entity_id',
                    'entity_name',
                    'is_customer_notified',
                    'is_visible_on_front',
                    'parent_id',
                    'status',
                ]
            ],
        ];
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
                $key . " key is not in found in results['billing_address']'s keys"
            );
        }
        foreach ($key2['payment'] as $key) {
            self::assertContains(
                $key,
                array_keys($results['payment']),
                $key . " key is not in found in results['payment']'s keys"
            );
        }
        foreach ($key2['status_histories'][0] as $key) {
            self::assertContains(
                $key,
                array_keys($results['status_histories'][0]),
                $key . " key is not in found in results['status_histories'][0]'s keys"
            );
        }
    }
}