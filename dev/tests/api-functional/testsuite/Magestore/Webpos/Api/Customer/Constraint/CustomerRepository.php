<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 28/12/2017
 * Time: 14:17
 */

namespace Magestore\Webpos\Api\Customer\Constraint;

/**
 * Class CustomerRepository
 * @package Magestore\Webpos\Api\Customer\Constraint
 */
class CustomerRepository
{
    /**
     * Constraint set key for Get Customer List
     * API: Get Customer List
     */
    public function GetList()
    {
        $keys = [
            'telephone',
            'subscriber_status',
            'full_name',
            'additional_attributes',
            'id',
            'group_id',
            'created_at',
            'updated_at',
            'email',
            'firstname',
            'lastname',
            'store_id',
            'website_id',
            'addresses',
            'disable_auto_group_change',
        ];
        return $keys;
    }

    /**
     * Constraint set key for Create Customer
     * API: Create Customer
     */
    public function CreateCustomer()
    {
        $keys = [
            'telephone',
            'subscriber_status',
            'full_name',
            'additional_attributes',
            'id',
            'group_id',
            'updated_at',
            'email',
            'firstname',
            'lastname',
            'store_id',
            'website_id',
            'addresses',
            'disable_auto_group_change',
        ];
        return $keys;
    }
}