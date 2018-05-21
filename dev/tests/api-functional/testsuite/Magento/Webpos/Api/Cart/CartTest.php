<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 26/12/2017
 * Time: 09:31
 */

namespace Magento\Webpos\Api\Cart;

use Magento\TestFramework\TestCase\WebapiAbstract;
use Magento\Framework\Webapi\Rest\Request as RestRequest;
/**
 * Class CartTest
 * @package Magento\Webpos\Api\Cart
 */
class CartTest extends WebapiAbstract
{
    const RESOURCE_PATH = '/V1/webpos/checkout/';

    /**
     * Order send mail
     */
    public function testSendEmail()
    {
        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH . 'sendEmail?',
                'httpMethod' => RestRequest::HTTP_METHOD_POST,
            ]
        ];
        $requestData = [
            'email' => 'roni_cost@example.com',
            'incrementId' => '000000398'
        ];
        $results = $this->_webApiCall($serviceInfo, $requestData);
        $results = explode(',', $results);
        $this->assertNotNull($results);
        self::assertContains(
            (string)'The order #'.$requestData['incrementId'].' has been sent to the customer '.$requestData['email'].'',
            (string)$results[1],
            'Send Email was wrong.'
        );
        $keys = [
            'error',
            'message',
        ];
        foreach ($keys as $key) {
            self::assertContains(
                $key,
                array_keys($results),
                $key . " key is not in found in result['items'][0]'s keys"
            );
        }
    }
}