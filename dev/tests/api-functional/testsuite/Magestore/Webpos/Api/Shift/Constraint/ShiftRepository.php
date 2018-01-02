<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 28/12/2017
 * Time: 16:36
 */

namespace Magestore\Webpos\Api\Shift\Constraint;

/**
 * Class ShiftRepository
 * @package Magestore\Webpos\Api\Shift\Constraint
 */
class ShiftRepository
{
    /**
     * Constraint set key for Get List Session
     * API Name: Get List Session
     */
    public function GetList()
    {
        $keys = [
            'entity_id',
            'shift_id',
            'staff_id',
            'location_id',
            'opened_at',
            'updated_at',
            'float_amount',
            'base_float_amount',
            'closed_amount',
            'base_closed_amount',
            'status',
            'cash_left',
            'base_cash_left',
            'closed_note',
            'opened_note',
            'total_sales',
            'base_total_sales',
            'balance',
            'base_balance',
            'cash_sale',
            'base_cash_sale',
            'cash_added',
            'base_cash_added',
            'cash_removed',
            'base_cash_removed',
            'session',
            'base_currency_code',
            'shift_currency_code',
            'store_id',
            'pos_name',
            'pos_id',
            'sale_summary',
            'cash_transaction',
        ];
        return $keys;
    }

    /**
     * Constraint set key for Close Session
     * API Name: Close Session
     */
    public function Save()
    {
        $key1 = [
            'entity_id',
            'shift_id',
            'staff_id',
            'location_id',
            'float_amount',
            'base_float_amount',
            'closed_amount',
            'base_closed_amount',
            'cash_left',
            'base_cash_left',
            'total_sales',
            'base_total_sales',
            'base_balance',
            'balance',
            'cash_sale',
            'base_cash_sale',
            'cash_added',
            'base_cash_added',
            'cash_removed',
            'base_cash_removed',
            'opened_at',
            'closed_at',
            'opened_note',
            'closed_note',
            'status',
            'base_currency_code',
            'shift_currency_code',
            'indexeddb_id',
            'updated_at',
            'pos_id',
            'profit_loss_reason',
            'sale_summary',
            'cash_transaction',
            'zreport_sales_summary',
            'pos_name',
        ];
        $key2 = [
            '0' => [
                'zreport_sales_summary' => [
                    'grand_total',
                    'discount_amount',
                    'total_refunded',
                    'giftvoucher_discount',
                    'rewardpoints_discount',
                ],
            ]
        ];
        return [
            'key1' => $key1,
            'key2' => $key2,
        ];
    }

    /**
     * Constraint set key for Validate Session
     * API Name: Validate Session
     */
    public function ValidateSession()
    {
        $key1 = [
            'entity_id',
            'shift_id',
            'staff_id',
            'location_id',
            'float_amount',
            'base_float_amount',
            'closed_amount',
            'base_closed_amount',
            'cash_left',
            'base_cash_left',
            'total_sales',
            'base_total_sales',
            'base_balance',
            'balance',
            'cash_sale',
            'base_cash_sale',
            'cash_added',
            'base_cash_added',
            'cash_removed',
            'base_cash_removed',
            'opened_at',
            'closed_at',
            'opened_note',
            'closed_note',
            'status',
            'base_currency_code',
            'shift_currency_code',
            'indexeddb_id',
            'updated_at',
            'pos_id',
            'profit_loss_reason',
            'sale_summary',
            'cash_transaction',
            'zreport_sales_summary',
            'pos_name',
        ];
        $key2 = [
            '0' => [
                'zreport_sales_summary' => [
                    'grand_total',
                    'discount_amount',
                    'total_refunded',
                    'giftvoucher_discount',
                    'rewardpoints_discount',
                ],
            ]
        ];
        return [
            'key1' => $key1,
            'key2' => $key2,
        ];
    }

    /**
     * Constraint set key for Open Session
     * API Name: Open Session
     */
    public function OpenSession()
    {
        $key1 = [
            'entity_id',
            'shift_id',
            'staff_id',
            'location_id',
            'float_amount',
            'base_float_amount',
            'closed_amount',
            'base_closed_amount',
            'cash_left',
            'base_cash_left',
            'total_sales',
            'base_total_sales',
            'base_balance',
            'balance',
            'cash_sale',
            'base_cash_sale',
            'cash_added',
            'base_cash_added',
            'cash_removed',
            'base_cash_removed',
            'opened_at',
            'closed_at',
            'opened_note',
            'closed_note',
            'status',
            'base_currency_code',
            'shift_currency_code',
            'indexeddb_id',
            'updated_at',
            'pos_id',
            'profit_loss_reason',
            'sale_summary',
            'cash_transaction',
            'zreport_sales_summary',
            'pos_name',
        ];
        $key2 = [
            '0' => [
                'zreport_sales_summary' => [
                    'grand_total',
                    'discount_amount',
                    'total_refunded',
                    'giftvoucher_discount',
                    'rewardpoints_discount',
                ],
            ]
        ];
        return [
            'key1' => $key1,
            'key2' => $key2,
        ];
    }
}