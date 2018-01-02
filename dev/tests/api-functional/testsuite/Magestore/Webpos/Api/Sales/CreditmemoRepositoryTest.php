<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 25/12/2017
 * Time: 16:50
 */

namespace Magestore\Webpos\Api\Sales;

use Magento\TestFramework\Helper\Bootstrap;
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
     * @var \Magestore\Webpos\Api\Sales\Constraint\CreditmemoRepository
     */
    protected $creditmemoRepository;

    protected function setUp()
    {
        $this->creditmemoRepository = Bootstrap::getObjectManager()->get('\Magestore\Webpos\Api\Sales\Constraint\CreditmemoRepository');
    }

    /**
     * API Name: Refund Order
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
        // Get the key constraint for API Refund Order. Call From Folder Constraint
        $keys = $this->creditmemoRepository->SaveCreditmemo();

        $key1 = $keys['key1'];
        foreach ($key1 as $key) {
            self::assertContains(
                $key,
                array_keys($results),
                $key . " key is not in found in result['items'][0]'s keys"
            );
        }

        $key2 = $keys['key2'];
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