<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 25/12/2017
 * Time: 15:28
 */

namespace Magento\Webpos\Api\Sales;

use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestFramework\TestCase\WebapiAbstract;
use Magento\Framework\Webapi\Rest\Request as RestRequest;
/**
 * Class InvoiceRepositoryTest
 * @package Magento\Webpos\Api\Sales
 */
class InvoiceRepositoryTest extends WebapiAbstract
{
    const RESOURCE_PATH = '/V1/webpos/invoices/';


    /**
     * @var \Magento\Webpos\Api\CurrentSessionId\CurrentSessionIdTest
     */
    protected $currentSession;

    protected function setUp()
    {
        $this->currentSession = Bootstrap::getObjectManager()->get('\Magento\Webpos\Api\CurrentSessionId\CurrentSessionIdTest');
    }

    /**
     * API Name: Update Qty before invoice
     */
    public function testUpdateQty() {
        $requestData = [
            'items' => [
                [
                    'qty' => '1',
                    'entity_id' => '19'
                ], [
                    'qty' => '1',
                    'entity_id' => '21'
                ], [
                    'qty' => '1',
                    'entity_id' => '22'
                ], [
                    'qty' => '1',
                    'entity_id' => '23'
                ], [
                    'qty' => '1',
                    'entity_id' => '25'
                ]
            ],
            'order_id' => 'WP11513743849738'
        ];

        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH . 'updateqty?',
                'httpMethod' => RestRequest::HTTP_METHOD_POST,
            ]
        ];

        $results = $this->_webApiCall($serviceInfo, $requestData);
        \Zend_Debug::dump($results);
        $this->assertNotNull($results);
        $this->assertGreaterThanOrEqual(
            '1',
            $results['total_count'],
            'The results doesn\'t have items.'
        );
    }

    /**
     * API Name: Invoice Order
     */
    public function testSaveInvoice() {
        $session = $this->currentSession->getCurrentSessionId();

        $requestData = [
            "entity" => [
                "baseCurrencyCode" => "USD",
                "baseDiscountAmount" => "0",
                "baseGrandTotal" => "66",
                "baseShippingAmount" => "0",
                "baseShippingInclTax" => "0",
                "baseShippingTaxAmount" => "0",
                "baseSubtotal" => "66",
                "baseSubtotalInclTax" => "66",
                "baseTaxAmount" => "0",
                "baseToGlobalRate" => "1",
                "baseToOrderRate" => "1",
                "billingAddressId" => "58",
                "comments" => [],
                "createdAt" => '2017-12-25 09:25:17',
                "discountAmount" =>'0',
                "extensionAttributes" => '',
                "globalCurrencyCode" => 'USD',
                "grandTotal" => '66',
                "items" => [
                    [
                        "rowTotal" => "34",
                        "orderItemId" => 46,
                        "qty" => 1,
                        "sku" => "24-MB01",
                        "price" => "34",
                        "taxAmount" => "0",
                        "rowTotalInclTax" => "34",
                        "basePrice" => 34,
                        "discountAmount" => 0,
                        "name" => "Joust Duffle Bag",
                    ],
                    [
                        "rowTotal" => 32,
                        "orderItemId" => 47,
                        "qty" => 1,
                        "sku" => "24-MB04",
                        "price" => 32,
                        "taxAmount" => 0,
                        "rowTotalInclTax" => 32,
                        "basePrice" => 32,
                        "discountAmount" => 0,
                        "name" => "Strive Shoulder Pack",
                    ]
                ],
                "orderCurrencyCode" => "USD",
                "orderId" => 35,
                "shippingAddressId" => 58,
                "shippingAmount" => 0,
                "shippingInclTax" => 0,
                "shippingTaxAmount" => 0,
                "state" => 2,
                "storeCurrencyCode" => "USD",
                "storeId" => 1,
                "storeToBaseRate" => 0,
                "storeToOrderRate" => 0,
                "subtotal" => 66,
                "subtotalInclTax" => 66,
                "taxAmount" => 0,
                "totalQty" => 2,
                "updatedAt" => "2017-12-25 09:25:17.945"
            ]
        ];

        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH . 'create?session='.$session.'',
                'httpMethod' => RestRequest::HTTP_METHOD_POST,
            ]
        ];

        $results = $this->_webApiCall($serviceInfo, $requestData);
        \Zend_Debug::dump($results);
        $this->assertNotNull($results);
    }
}