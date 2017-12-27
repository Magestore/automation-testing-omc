<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 27/12/2017
 * Time: 10:04
 */

namespace Magestore\Webpos\Api\CurrentSessionId;

use Magento\TestFramework\TestCase\WebapiAbstract;
/**
 * Class CurrentSessionIdTest
 * @package Magestore\Webpos\Api\CurrentSessionId
 */
class CurrentSessionIdTest extends WebapiAbstract
{
    /**
     * @var $username
     */
    protected $username = 'magentoadmin';
    /**
     * @var $password
     */
    protected $password = 'admin123';

    const RESOURCE_PATH = '/V1/webpos/staff/login';

    /**
     * Get the current session Id
     */
    public function getCurrentSessionId()
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
        return $this->_webApiCall($serviceInfo, $requestData);
    }
}