<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 28/12/2017
 * Time: 15:42
 */

namespace Magestore\Webpos\Api\Sales\Constraint;

/**
 * Class OrderRepository
 * @package Magestore\Webpos\Api\Sales\Constraint
 */
class OrderRepository
{
    /**
     * Constraint set key for Get List Order
     * API Name: Get List Order
     */
    public function GetList()
    {
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
        return [
            'key1' => $key1,
            'key2' => $key2,
        ];
    }

    /**
     * Constraint set key for Order add comment
     * API Name: Order add comment
     */
    public function AddComment()
    {
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
            'store_name',
            'billing_address',
            'payment',
            'status_histories',
            'extension_attributes',
        ];
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
        return [
            'key1' => $key1,
            'key2' => $key2,
        ];
    }
}