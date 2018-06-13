<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 26/12/2017
 * Time: 09:31
 */

namespace Magento\Webpos\Api\Cart;

use Magento\TestFramework\Helper\Bootstrap;
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
     * @var \Magento\Sales\Service\V1\OrderCreateTest $orderCreateTest
     */
    protected $orderCreateTest;

    /**
     * @var \Magento\Webpos\Api\Staff\LoginTest $currentSession
     */
    protected $currentSession;

    protected function setUp()
    {
        $this->orderCreateTest = Bootstrap::getObjectManager()->create(\Magento\Sales\Service\V1\OrderCreateTest::class);
        $this->currentSession = Bootstrap::getObjectManager()->create(\Magento\Webpos\Api\Staff\LoginTest::class);
    }

    /**
     * Order send mail
     */
    public function testSendEmail()
    {
        $this->orderCreateTest->testOrderCreate();
        $session = $this->currentSession->testStaffLogin();
        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH . 'sendEmail?',
                'httpMethod' => RestRequest::HTTP_METHOD_POST,
            ]
        ];
        $requestData = [
            'email' => 'email@example.com',
            'incrementId' => '100000001',
            'session' => $session
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