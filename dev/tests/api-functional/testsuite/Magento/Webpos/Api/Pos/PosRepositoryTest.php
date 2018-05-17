<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 25/12/2017
 * Time: 14:31
 */

namespace Magento\Webpos\Api\Pos;

use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestFramework\TestCase\WebapiAbstract;
use Magento\Framework\Webapi\Rest\Request as RestRequest;
/**
 * Class PosRepositoryTest
 * @package Magento\Webpos\Api\Pos
 */
class PosRepositoryTest extends WebapiAbstract
{
	const POS_LIST_RESOURCE_PATH = '/V1/webpos/poslist';
	const ASSIGN_STAFF_RESOURCE_PATH = '/V1/webpos/posassign';

    /**
     * @var \Magento\Webpos\Api\Staff\LoginTest
     */
    protected $currentSession;

    /**
     * @var \Magento\Webpos\Api\Pos\Constraint\PosRepository
     */
    protected $posRepository;

    protected function setUp()
    {
        $this->currentSession = Bootstrap::getObjectManager()->get('\Magento\Webpos\Api\Staff\LoginTest');
        $this->posRepository = Bootstrap::getObjectManager()->get('\Magento\Webpos\Api\Pos\Constraint\PosRepository');
    }

	/**
	 * Api Name: POS Assign
	 */
	public function testAssignStaff()
	{
		$serviceInfo = [
			'rest' => [
				'resourcePath' => self::ASSIGN_STAFF_RESOURCE_PATH,
				'httpMethod' => RestRequest::HTTP_METHOD_POST,
			],
		];
		$requestData = [
			"location_id" => 1,
            "current_session_id" => $this->currentSession->testStaffLogin(),
            "pos_id" => "1"
		];
		$result = $this->_webApiCall($serviceInfo, $requestData);
		self::assertTrue(
			$result,
			'result is not TRUE'
		);
	}
}