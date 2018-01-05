<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 28/12/2017
 * Time: 14:32
 */

namespace Magestore\Webpos\Api\Pos\Constraint;

/**
 * Class PosRepository
 * @package Magestore\Webpos\Api\Pos\Constraint
 */
class PosRepository
{
    /**
     * Constraint set key for Get list POS
     * API Name: Get list POS
     */
    public function GetList()
    {
        $key1 = [
            'pos_name',
            'location_id',
            'staff_id',
            'store_id',
            'status',
            'denomination_ids',
            'denominations'
        ];
        $denominationKeys = [
            'denomination_id',
            'denomination_name',
            'denomination_value',
            'pos_ids',
            'sort_order'
        ];
        return [
            'key1' => $key1,
            'denominationKey' => $denominationKeys,
        ];
    }
}