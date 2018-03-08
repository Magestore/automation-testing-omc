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

/**
 * Class Curl
 * @package Magento\Webpos\Test\Handler\Role
 */
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
    protected $mappingData = [
        'resource' => [
            'manage_order' => [
                'Magestore_Webpos::manage_order',
                'Magestore_Webpos::manage_order_me',
                'Magestore_Webpos::manage_order_location',
                'Magestore_Webpos::manage_all_order'
            ],
            'manage_order_created_by_this_staff' => [
                'Magestore_Webpos::manage_order',
                'Magestore_Webpos::manage_order_me'
            ],
            'manage_order_created_at_location_of_staff' => [
                'Magestore_Webpos::manage_order',
                'Magestore_Webpos::manage_order_location',
                'Magestore_Webpos::manage_shift',
                'Magestore_Webpos::manage_shift_adjustment',
                'Magestore_Webpos::open_shift',
                'Magestore_Webpos::close_shift'

            ],
            'manage_all_order' => [
                'Magestore_Webpos::manage_order',
                'Magestore_Webpos::manage_all_order',
                'Magestore_Webpos::manage_shift',
                'Magestore_Webpos::manage_shift_adjustment',
                'Magestore_Webpos::open_shift',
                'Magestore_Webpos::close_shift'
            ],
            'manage_inventory' => [
                'Magestore_Webpos::manage_inventory'
            ],
            'manage_discount' => [
                'Magestore_Webpos::manage_discount',
                'Magestore_Webpos::apply_discount_per_cart',
                'Magestore_Webpos::apply_coupon',
                'Magestore_Webpos::apply_discount_per_item',
                'Magestore_Webpos::apply_custom_price',
                'Magestore_Webpos::all_discount'
            ],
            'manage_discount_apply_all_discount' => [
                'Magestore_Webpos::manage_discount',
                'Magestore_Webpos::all_discount'
            ],
            'manage_order_and_apply_custom_discount_per_cart' => [
                'Magestore_Webpos::manage_order',
                'Magestore_Webpos::manage_order_me',
                'Magestore_Webpos::manage_order_location',
                'Magestore_Webpos::manage_all_order',
                'Magestore_Webpos::manage_discount',
                'Magestore_Webpos::apply_discount_per_cart'
            ],
            'manage_order_and_apply_coupon_code' => [
                'Magestore_Webpos::manage_order',
                'Magestore_Webpos::manage_order_me',
                'Magestore_Webpos::manage_order_location',
                'Magestore_Webpos::manage_all_order',
                'Magestore_Webpos::manage_discount',
                'Magestore_Webpos::apply_coupon'
            ],
            'manage_order_and_apply_custom_discount_per_item' => [
                'Magestore_Webpos::manage_order',
                'Magestore_Webpos::manage_order_me',
                'Magestore_Webpos::manage_order_location',
                'Magestore_Webpos::manage_all_order',
                'Magestore_Webpos::manage_discount',
                'Magestore_Webpos::apply_discount_per_item'
            ],
            'manage_order_and_apply_custom_price' => [
                'Magestore_Webpos::manage_order',
                'Magestore_Webpos::manage_order_me',
                'Magestore_Webpos::manage_order_location',
                'Magestore_Webpos::manage_all_order',
                'Magestore_Webpos::manage_discount',
                'Magestore_Webpos::apply_custom_price',
            ]
        ]
    ];

    /**
     * Url for delete data.
     *
     * @var string
     */
    protected $deleteUrl = 'webposadmin/staff_role/delete/id/%d/';

    /**
     * @param FixtureInterface|null $fixture
     * @throws \Exception
     */
    public function deleteRole(FixtureInterface $fixture = null)
    {
        $roleId = $fixture->getData('role_id');
        $this->deleteUrl = sprintf($this->deleteUrl, $roleId);
        $url = $_ENV['app_backend_url'] . $this->deleteUrl;
        $curl = new BackendDecorator(new CurlTransport(), $this->_configuration);
        $curl->write($url);
        $response = $curl->read();
        $curl->close();
        if (!strpos($response, 'data-ui-id="messages-message-success"')) {
            throw new \Exception(
                "Role entity delete by curl handler was not successful! Response: $response"
            );
        }
    }

    /**
     * @param FixtureInterface|null $fixture
     * @return array|mixed
     * @throws \Exception
     */
    public function persist(FixtureInterface $fixture = null)
    {
        $data = $this->replaceMappingData($fixture->getData());
        $data['role_staff'] = '';
        if(isset($data['staff_id']))
        {
            foreach ($data['staff_id'] as $staffId) {
                if ($data['role_staff'] == '') {
                    $data['role_staff'] = $staffId;
                } else {
                    $data['role_staff'] .= '&' . $staffId;
                }
            }
//            $data['role_staff'] = $data['staff_id'];
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