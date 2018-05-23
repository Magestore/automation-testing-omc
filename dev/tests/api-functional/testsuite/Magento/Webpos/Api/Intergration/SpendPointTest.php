<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/21/18
 * Time: 5:16 PM
 */

namespace Magento\Webpos\Api\Intergration;

use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestFramework\TestCase\WebapiAbstract;
use Magento\Framework\Webapi\Rest\Request as RestRequest;
/**
 * Class SpendPointTest
 * @package Magento\Webpos\Api\Intergration
 */
class SpendPointTest extends WebapiAbstract
{
    const INTEGRATION_RESOURCE_PATH = '/V1/webpos/integration/spendPoint';

    const RESOURCE_PATH = '/V1/webpos/checkout/';

    /**
     * @var \Magento\Webpos\Api\Staff\LoginTest $currentSession
     */
    protected $currentSession;

    /**
     * @var \Magento\TestFramework\ObjectManager $objectManager
     */
    protected $objectManager;

    /**
     * @var \Magento\Webpos\Api\Checkout\SaveCartTest $saveCart
     */
    protected $saveCart;

    protected function setUp()
    {
        $this->objectManager = Bootstrap::getObjectManager();
        $this->currentSession = Bootstrap::getObjectManager()->create(\Magento\Webpos\Api\Staff\LoginTest::class);
        $this->saveCart = Bootstrap::getObjectManager()->create(\Magento\Webpos\Api\Checkout\SaveCartTest::class);
    }

    /**
     * Order Spend Point
     */
    public function testSpendPoint()
    {
        $session = $this->currentSession->testStaffLogin();
        $saveCart = $this->saveCart->callAPISaveCart($session);
        \Zend_Debug::dump($saveCart);
        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::INTEGRATION_RESOURCE_PATH . '?session='.$session,
                'httpMethod' => RestRequest::HTTP_METHOD_POST,
            ]
        ];
        $requestData = [
            'quote_id' => $saveCart['quote_init']['quote_id'],
            'rule_id' => '2',
            'used_point' => '40',
            'website_id' => '1',
        ];
        $results = $this->_webApiCall($serviceInfo, $requestData);
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