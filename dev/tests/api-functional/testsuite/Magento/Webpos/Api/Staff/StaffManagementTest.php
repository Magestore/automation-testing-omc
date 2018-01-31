<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 20/12/2017
 * Time: 14:19
 */

namespace Magento\Webpos\Api\Staff;

use Magento\TestFramework\TestCase\WebapiAbstract;
use Magento\TestFramework\Helper\Bootstrap;
/**
 * Class StaffManagementTest
 * @package Magento\Webpos\Api\Staff
 */
class StaffManagementTest extends WebapiAbstract
{
	const RESOURCE_PATH = '/V1/webpos/staff/login';

    /**
     * @var \Magento\Webpos\Api\CurrentSessionId\CurrentSessionIdTest
     */
    protected $currentSession;

    protected function setUp()
    {
        $this->currentSession = Bootstrap::getObjectManager()->get('\Magento\Webpos\Api\CurrentSessionId\CurrentSessionIdTest');
    }

	public function testStaffLogin()
	{
		$result = $this->currentSession->getCurrentSessionId();

		$this->assertNotNull($result);
		$this->assertTrue(
            is_string($result),
            'Login failed'
        );
	}
}