<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 28/12/2017
 * Time: 14:17
 */

namespace Magento\Webpos\Api\Customer\Constraint;

/**
 * Class CustomerRepository
 * @package Magento\Webpos\Api\Customer\Constraint
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

    /**
     * Constraint set key for Search Customer
     * API: Search Customer
     */
    public function SearchCustomer()
    {
        $key1 = [
            'items',
            'search_criteria',
            'total_count'
        ];
        $key2 = [
            'items' => [
                0 => [
                    'telephone',
                    'subscriber_status',
                    'full_name',
                    'additional_attributes',
                    'id',
                    'group_id',
                    'created_at',
                    'updated_at',
                    'created_in',
                    'email',
                    'firstname',
                    'lastname',
                    'store_id',
                    'website_id',
                    'addresses',
                    'disable_auto_group_change'
                ]
            ]
        ];
        $key3 = [
            'search_criteria' => [
                'filter_groups',
                'sort_orders',
                'page_size',
                'current_page',
            ]
        ];
        $key4 = [
            'search_criteria' => [
                'sort_orders' => [
                    0 => [
                        'field',
                        'direction'
                    ]
                ]
            ]
        ];
        return [
            'key1' => $key1,
            'key2' => $key2,
            'key3' => $key3,
            'key4' => $key4
        ];
    }
}