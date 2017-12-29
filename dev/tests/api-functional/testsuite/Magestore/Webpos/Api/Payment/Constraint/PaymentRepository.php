<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 28/12/2017
 * Time: 14:27
 */

namespace Magestore\Webpos\Api\Payment\Constraint;

/**
 * Class PaymentRepository
 * @package Magestore\Webpos\Api\Payment\Constraint
 */
class PaymentRepository
{
    /**
     * Constraint set key for Get Payment to Take payment
     * API: Get Payment to Take payment
     */
    public function GetList()
    {
        $keys = [
            'items' => [
                '0' => [
                    'code',
                    'title',
                    'information',
                    'type',
                    'is_default',
                    'is_reference_number',
                    'is_pay_later',
                ]
            ]
        ];
        return $keys;
    }
}