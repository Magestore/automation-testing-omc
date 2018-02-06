<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 28/12/2017
 * Time: 14:41
 */

namespace Magento\Webpos\Api\Sales\Constraint;

/**
 * Class CreditmemoRepository
 * @package Magento\AutoTestWebposToaster\Api\Sales\Constraint
 */
class CreditmemoRepository
{
    /**
     * Constraint set key for Refund Order
     * API Name: Refund Order
     */
    public function SaveCreditmemo()
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
            'items_info_buy'
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
                        'base_unit_price',
                        'options_label',
                        'custom_sales_info',
                    ]
                ]
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
                    'base_gift_voucher_discount',
                    'amount_refunded',
                    'name',
                    'order_id',
                    'price',
                    'product_id',
                    'base_discount_tax_compensation_amount',
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
                'amount_refunded',
                'base_amount_ordered',
                'base_amount_paid',
                'base_amount_refunded',
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
                    'parent_id',
                ]
            ],
        ];
        return [
            'key1' => $key1,
            'key2' => $key2,
        ];
    }
}