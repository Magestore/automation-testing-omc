<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 28/12/2017
 * Time: 15:57
 */

namespace Magestore\Webpos\Api\Shift\Constraint;

/**
 * Class CashTransactionRepository
 * @package Magestore\Webpos\Api\Shift\Constraint
 */
class CashTransactionRepository
{
    /**
     * Constraint set key for Make Adjustment Session
     * API Name: Make Adjustment Session
     */
    public function Save()
    {
        $keys = [
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
        return $keys;
    }
}