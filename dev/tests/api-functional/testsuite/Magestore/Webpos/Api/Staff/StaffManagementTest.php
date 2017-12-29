<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 20/12/2017
 * Time: 14:19
 */

namespace Magestore\Webpos\Api\Staff;


use Magento\TestFramework\TestCase\WebapiAbstract;

class StaffManagementTest extends WebapiAbstract
{
	const RESOURCE_PATH = '/V1/webpos/staff/login';

	public function testStaffLogin()
	{
		$serviceInfo = [
			'rest' => [
				'resourcePath' => self::RESOURCE_PATH,
				'httpMethod' => \Magento\Framework\Webapi\Rest\Request::HTTP_METHOD_POST,
			],
		];

		$requestData = [
			'staff' => [
				'username' => 'admin',
				'password' => 'admin123'
			],
		];
		$result = $this->_webApiCall($serviceInfo, $requestData);
		$this->assertNotNull($result);

	}
}