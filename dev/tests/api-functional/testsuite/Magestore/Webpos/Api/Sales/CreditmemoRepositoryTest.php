<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 25/12/2017
 * Time: 16:50
 */

namespace Magestore\Webpos\Api\Sales;

use Magento\TestFramework\TestCase\WebapiAbstract;
use Magento\Framework\Webapi\Rest\Request as RestRequest;
/**
 * Class CreditmemoRepositoryTest
 * @package Magestore\Webpos\Api\Sales
 */
class CreditmemoRepositoryTest extends WebapiAbstract
{
    const RESOURCE_PATH = '/V1/webpos/creditmemo/';

    /**
     * Refund Order
     */
    public function testSaveCreditmemo()
    {
        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH . 'create?',
                'httpMethod' => RestRequest::HTTP_METHOD_POST,
            ]
        ];

        $requestData = [
            'entity' => [
                'items' => [
                    'qty' => '1',
                    'order_item_id' => '18',
                ],
                'order_id' => '10',
                'base_currency_code' => 'USD',
                'store_currency_code' => 'USD',
                'adjustment_positive' => '0',
                'shipping_amount' => '0',
                'adjustment_negative' => '0',
            ]
        ];

        $results = $this->_webApiCall($serviceInfo, $requestData);

        // Dump the result to check "How does it look like?"
         \Zend_Debug::dump($results);

        $this->assertNotNull($results);
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
        foreach ($key1 as $key) {
            self::assertContains(
                $key,
                array_keys($results),
                $key . " key is not in found in result['items'][0]'s keys"
            );
        }
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
        foreach ($key2['items_info_buy']['items'][0] as $key) {
            self::assertContains(
                $key,
                array_keys($results['items_info_buy']['items'][0]),
                $key . " key is not in found in results['items_info_buy']['items'][0]'s keys"
            );
        }
        foreach ($key2['items'][0] as $key) {
            self::assertContains(
                $key,
                array_keys($results['items'][0]),
                $key . " key is not in found in results['items'][0]'s keys"
            );
        }
        foreach ($key2['billing_address'] as $key) {
            self::assertContains(
                $key,
                array_keys($results['billing_address']),
                $key . " key is not in found in result['billing_address']'s keys"
            );
        }
        foreach ($key2['payment'] as $key) {
            self::assertContains(
                $key,
                array_keys($results['payment']),
                $key . " key is not in found in result['payment']'s keys"
            );
        }
        foreach ($key2['status_histories'][0] as $key) {
            self::assertContains(
                $key,
                array_keys($results['status_histories'][0]),
                $key . " key is not in found in result['status_histories'][0]'s keys"
            );
        }
    }
}