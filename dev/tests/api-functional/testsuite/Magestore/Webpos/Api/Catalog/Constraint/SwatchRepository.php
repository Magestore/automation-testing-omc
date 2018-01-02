<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 28/12/2017
 * Time: 14:00
 */

namespace Magestore\Webpos\Api\Catalog\Constraint;

/**
 * Class SwatchRepository
 * @package Magestore\Webpos\Api\Catalog\Constraint
 */
class SwatchRepository
{
    /**
     * Constraint set key for GET ColorSwatch
     * API: GET ColorSwatch
     */
    public function GetList()
    {
        $key1 = [
            'items' => [
                '0' => [
                    'attribute_id',
                    'attribute_code',
                    'attribute_label',
                    'attribute_label',
                    'swatches',
                ]
            ]
        ];
        $key2 = [
            'items' => [
                '0' => [
                    'swatches' => [
                        '49' => [
                            'swatch_id',
                            'option_id',
                            'store_id',
                            'type',
                            'value',
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
}