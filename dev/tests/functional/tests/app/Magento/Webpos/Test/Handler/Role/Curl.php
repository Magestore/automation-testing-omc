<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 08/09/2017
 * Time: 14:37
 */

namespace Magento\Webpos\Test\Handler\Role;

use Magento\Mtf\Fixture\FixtureInterface;
use Magento\Mtf\Handler\Curl as AbstractCurl;
use Magento\Mtf\Util\Protocol\CurlTransport;
use Magento\Mtf\Util\Protocol\CurlInterface;
use Magento\Mtf\Util\Protocol\CurlTransport\BackendDecorator;

class Curl extends AbstractCurl implements RoleInterface
{
    /**
     * Url for saving data.
     *
     * @var string
     */
    protected $saveUrl = 'webposadmin/staff_role/save/';

    /**
     * Mapping values for data.
     *
     * @var array
     */
    protected $mappingData = [];


    public function persist(FixtureInterface $fixture = null)
    {
        $data = $this->replaceMappingData($fixture->getData());
        if(isset($data['staff_id']))
        {
            $data['role_staff'] = $data['staff_id'];
            unset($data['staff_id']);
        }
        $url = $_ENV['app_backend_url'] . $this->saveUrl;
        $curl = new BackendDecorator(new CurlTransport(), $this->_configuration);
        $curl->write($url, $data);
        $response = $curl->read();
        $curl->close();
        if (!strpos($response, 'data-ui-id="messages-message-success"')) {
            throw new \Exception(
                "Role entity creation by curl handler was not successful! Response: $response"
            );
        }

        $data['role_id'] = $this->getRoleId($fixture->getDisplayName());
        return ['role_id' => $data['role_id']];
    }

    /**
     * Get role id by name
     *
     * @param string $name
     * @return int|null
     */
    protected function getRoleId($name)
    {
        $url = $_ENV['app_backend_url'] . 'mui/index/render/';
        $data = [
            'namespace' => 'webpos_role_listing',
            'filters' => [
                'placeholder' => true,
                'display_name' => $name
            ],
            'isAjax' => true
        ];
        $curl = new BackendDecorator(new CurlTransport(), $this->_configuration);

        $curl->write($url, $data, CurlInterface::POST);
        $response = $curl->read();
        $curl->close();

        preg_match('/webpos_role_listing_data_source.+items.+"role_id":"(\d+)"/', $response, $match);
        return empty($match[1]) ? null : $match[1];
    }
}