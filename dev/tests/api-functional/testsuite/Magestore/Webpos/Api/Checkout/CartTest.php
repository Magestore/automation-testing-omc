<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 26/12/2017
 * Time: 09:31
 */

namespace Magestore\Webpos\Api\Checkout;

use Magento\TestFramework\TestCase\WebapiAbstract;
use Magento\Framework\Webapi\Rest\Request as RestRequest;
/**
 * Class CartTest
 * @package Magestore\Webpos\Api\CategoryRepository
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
            'email' => 'lionel123@gmail.com',
            'incrementId' => 'WP11513741610113'
        ];

        $results = $this->_webApiCall($serviceInfo, $requestData);
        $results = explode(',', $results);

        // Dump the result to check "How does it look like?"
        // \Zend_Debug::dump($results);

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