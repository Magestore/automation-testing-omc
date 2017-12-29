<?php
/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 12/28/2017
 * Time: 11:16 AM
 */

namespace Magento\PurchaseOrderSuccess\Test\Handler\ReturnOrder;

use Magento\Mtf\Fixture\FixtureInterface;
use Magento\Mtf\Handler\Curl as AbstractCurl;
use Magento\Mtf\Util\Protocol\CurlInterface;
use Magento\Mtf\Util\Protocol\CurlTransport;
use Magento\Mtf\Util\Protocol\CurlTransport\BackendDecorator;
use Magento\Setup\Exception;

class Curl extends AbstractCurl implements ReturnOrderInterface
{
    /**
     * Url for saving data.
     *
     * @var string
     */
    protected $saveUrl = 'purchaseordersuccess/returnOrder/save/';

    /**
     * Mapping values for data.
     *
     * @var array
     */
    protected $mappingData = [
        "warehouse_id" => [
            "Primary Warehouse(primary)" => "2"
        ]
    ];


    /**
     * @param FixtureInterface|null $fixture
     * @return array
     * @throws \Exception
     */
    public function persist(FixtureInterface $fixture = null)
    {
        $data = $this->replaceMappingData($fixture->getData());
        $supplier = $fixture->getDataFieldConfig('supplier_id')['source']->getSupplier();
        $data["supplier_id"] = $supplier->getSupplierId();
        $url = $_ENV['app_backend_url'] . $this->saveUrl;
        $curl = new BackendDecorator(new CurlTransport(), $this->_configuration);
        $curl->write($url, $data);
        $response = $curl->read();
        $curl->close();
        if (!strpos($response, 'data-ui-id="messages-message-success"')) {
            throw new \Exception(
                "Return request has been saved.! Response: $response"
            );
        }
        $data['return_code'] = $this->getReturnId($fixture->getReturnCode());

        return ['return_code' => $data['return_code']];
    }

    /**
     * Get pos id by name
     *
     * @param string $name
     * @return int|null
     */
    protected function getReturnId($name)
    {
        $url = $_ENV['app_backend_url'] . 'mui/index/render/';
        $data = [
            'namespace' => 'os_return_order_listing',
            'filters' => [
                'placeholder' => true,
                'return_code' => $name
            ],
            'isAjax' => true
        ];
        $curl = new BackendDecorator(new CurlTransport(), $this->_configuration);

        $curl->write($url, $data, CurlInterface::POST);
        $response = $curl->read();
        $curl->close();

        preg_match('/os_return_order_listing_data_source.+items.+"return_id":"(\d+)"/', $response, $match);

        return empty($match[1]) ? null : $match[1];
    }
}