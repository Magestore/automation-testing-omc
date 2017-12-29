<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 28/12/2017
 * Time: 13:22
 */

namespace Magestore\Webpos\Api\Catalog\Constraint;

/**
 * Class CategoryRepository
 * @package Magestore\Webpos\Api\Catalog\Constraint
 */
class CategoryRepository
{
    /**
     * Constraint set key for Get List Categories
     * API: Get List Categories
     */
    public function GetListCategories()
    {
        $keys = [
            'items' => [
                '0' => [
                    'id',
                    'name',
                    'children',
                    'image',
                    'position',
                    'level',
                    'first_category',
                    'parent_id',
                    'path'
                ]
            ]
        ];
        return $keys;
    }
}