<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/18/18
 * Time: 3:55 PM
 */

namespace Magento\Webpos\Api\PosAssign;

use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestFramework\TestCase\WebapiAbstract;
use Magento\Framework\Webapi\Rest\Request as RestRequest;
/**
 * Class AssignPosTest
 * @package Magento\Webpos\Api\PosAssign
 */
class AssignPosTest extends WebapiAbstract
{
    const POS_ASSIGN_RESOURCE_PATH = '/V1/webpos/posassign';

    /**
     * @var \Magento\Webpos\Api\Staff\LoginTest $currentSession
     */
    protected $currentSession;

    protected function setUp()
    {
        $this->currentSession = Bootstrap::getObjectManager()->get('\Magento\Webpos\Api\Staff\LoginTest');
    }

    /**
     * Api Name: POS Assign
     */
    public function testAssignStaff()
    {
        $session = $this->currentSession->testStaffLogin();
        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::POS_ASSIGN_RESOURCE_PATH.'/?session='.$session,
                'httpMethod' => RestRequest::HTTP_METHOD_POST,
            ],
        ];
        $requestData = [
            "pos_id" => "1",
            "location_id" => "1",
            "website_id" => "1",
            "current_session_id" => $this->currentSession->testStaffLogin(),
        ];
        $result = $this->_webApiCall($serviceInfo, $requestData);
//        \Zend_Debug::dump($result);
        self::assertNotNull(
            $result,
            'The message must be true. But it is'.$result
        );
    }
}