<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 26/12/2017
 * Time: 08:30
 */

namespace Magestore\Webpos\Api\Payment;

use Magento\TestFramework\TestCase\WebapiAbstract;
use Magento\Framework\Webapi\Rest\Request as RestRequest;
/**
 * Class PaymentRepositoryTest
 * @package Magestore\Webpos\Api\Payment
 */
class PaymentRepositoryTest extends WebapiAbstract
{
    const RESOURCE_PATH = '/V1/webpos/payments';

    /**
     * Get Payment to Take payment
     */
    public function testGetList()
    {
        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH .'?' ,
                'httpMethod' => RestRequest::HTTP_METHOD_GET,
            ]
        ];

        $results = $this->_webApiCall($serviceInfo);

        \Zend_Debug::dump($results);

        $this->assertNotNull($results);
        self::assertGreaterThanOrEqual(
            1,
            $results['total_count'],
            "The result doesn't have any item (total_count < 1)"
        );
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
        foreach ($keys['items'][0] as $key) {
            self::assertContains(
                $key,
                array_keys($results['items'][0]),
                $key . " key is not in found in results['items'][0]'s keys"
            );
        }
    }
}