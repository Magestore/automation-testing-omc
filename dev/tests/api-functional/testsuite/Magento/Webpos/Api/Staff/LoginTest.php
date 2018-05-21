<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 27/12/2017
 * Time: 10:04
 */

namespace Magento\Webpos\Api\Staff;

use Magento\TestFramework\TestCase\WebapiAbstract;
/**
 * Class LoginTest
 * @package Magento\Webpos\Api\Staff
 */
class LoginTest extends WebapiAbstract
{
    /**
     * @var $username
     */
    protected $username = 'admin';

    /**
     * @var $password
     */
    protected $password = 'admin123';

    /**
     * const RESOURCE_PATH
     */
    const RESOURCE_PATH = '/V1/webpos/staff/login';

    /**
     * test Staff LoginTest
     */
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
                'username' => $this->username,
                'password' => $this->password
            ],
        ];
        $result = $this->_webApiCall($serviceInfo, $requestData);
        return $result;
    }
}