<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/19/18
 * Time: 9:32 AM
 */

namespace Magento\Webpos\Api\Checkout;

use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestFramework\TestCase\WebapiAbstract;
use Magento\Framework\Webapi\Rest\Request as RestRequest;
/**
 * Class SendEmailTest
 * @package Magento\Webpos\Api\Checkout
 */
class SendEmailTest extends WebapiAbstract
{
    /**
     * const RESOURCE_PATH
     */
    const RESOURCE_PATH = '/V1/webpos/checkout/';

    /**
     * @var \Magento\Webpos\Api\Staff\LoginTest $currentSession
     */
    protected $currentSession;

    protected function setUp()
    {
        $this->objectManager = Bootstrap::getObjectManager();
        $this->currentSession = Bootstrap::getObjectManager()->create(\Magento\Webpos\Api\Staff\LoginTest::class);
    }

    /**
     * test API Send Email
     */
    public function testSendEmail() {
        $session = $this->currentSession->testStaffLogin();
        $requestData = [
            'email' => 'roni_cost@example.com',
            'website_id' => '1',
            'incrementId' => '000000001',
        ];
        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH . 'sendEmail/?session=' .$session,
                'httpMethod' => RestRequest::HTTP_METHOD_POST,
            ]
        ];
        $message = '{"error":false,"message":"The order #000000001 has been sent to the customer roni_cost@example.com"}';
        $results = $this->_webApiCall($serviceInfo, $requestData);
        $this->assertNotNull($results);
        self::assertContains(
            $message,
            $results,
            "The message send email is not wrong."
        );
    }
}