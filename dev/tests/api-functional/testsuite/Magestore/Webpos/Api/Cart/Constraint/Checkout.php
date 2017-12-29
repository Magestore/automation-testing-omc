<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 28/12/2017
 * Time: 13:22
 */

namespace Magestore\Webpos\Api\Cart\Constraint;

/**
 * Class CategoryRepository
 * @package Magestore\Webpos\Api\TaxClass\Constraint
 */
class Checkout
{
    /**
     * Constraint set key for save TaxClass
     * API: Save TaxClass
     */
    public function SaveCart()
    {
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
        return $keys;
    }

    /**
     * Constraint set key for Save Quote Data
     * API: Save Quote Data
     */
    public function SaveQuoteData()
    {
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
        return $keys;
    }

    /**
     * Constraint set key for Save Shipping Method
     * API: Save Shipping Method
     */
    public function SaveShippingMethod()
    {
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
        return $keys;
    }

    /**
     * Constraint set key for Place Order
     * API: Place Order
     */
    public function PlaceOrder()
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
            'webpos_paypal_invoice_id',
            'webpos_init_data',
            'webpos_shift_id',
            'applied_rule_ids',
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
        return [
            'key1' => $key1,
            'key2' => $key2
        ];
    }

    /**
     * Constraint set key for Spend Point
     * API: Spend Point
     */
    public function SpendPoint()
    {
        $key1 = [
            'items',
            'shipping',
            'payment',
            'quote_init',
            'totals',
            'giftcard',
            'rewardpoints',
            'storecredit',
        ];
        $key2 = [
            'items' => [
                '0' => [
                    'item_id',
                    'quote_id',
                    'created_at',
                    'updated_at',
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
                ],
            ],
            'shipping' => [
                '0' => [
                    'code',
                    'title',
                    'description',
                    'error_message',
                    'price_type',
                    'price',
                ]
            ],
            'payment' => [
                '0' => [
                    'code',
                    'icon_class',
                    'title',
                    'information',
                    'type',
                    'type_id',
                    'is_default',
                    'is_reference_number',
                    'is_pay_later',
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
            'giftcard' => [
                'existed_codes',
                'used_codes',
            ],
            'rewardpoints' => [
                'used_point',
                'balance',
                'max_points',
            ],
        ];
        return [
            'key1' => $key1,
            'key2' => $key2
        ];
    }
}