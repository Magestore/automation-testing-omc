<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 11/12/2017
 * Time: 23:20
 */
namespace Magento\BarcodeSuccess\Test\Handler\Template;

use Magento\Mtf\Fixture\FixtureInterface;
use Magento\Mtf\Handler\Curl as AbstractCurl;
use Magento\Mtf\Config\DataInterface;
use Magento\Mtf\System\Event\EventManagerInterface;
use Magento\Mtf\Util\Protocol\CurlInterface;
use Magento\Mtf\Util\Protocol\CurlTransport;
use Magento\Mtf\Util\Protocol\CurlTransport\BackendDecorator;
class Curl extends AbstractCurl
{

    protected $mappingData = [
        'status'  => [
            'Active' => '1',
            'Inactive' => '2'
        ],
        'type'  => [
            'Standard Barcode' => 'standard',
            'A4 Barcode' => 'a4',
            'Jewelry Barcode' => 'jewelry'
        ],
        'symbology'  => [
            'Code-128' => 'code128',
            'Code-25' => 'code25',
            'Interleaved 2 of 5' => 'code25interleaved',
            'Code-39' => 'code39',
            'Ean-13' => 'ean13',
            'Identcode' => 'identcode',
            'Itf14' => 'itf14',
            'Leitcode' => 'leitcode',
            'Royalmail' => 'royalmail'
        ],
        'measurement_unit' => [
            'mm' => 'mm',
            'cm' => 'cn',
            'in' => 'in',
            'px' => 'px',
            '%' => '%'
        ],
        'product_attribute_show_on_barcode' => [
            'SKU' => 'sku',
            'Product Name' => 'name',
            'Price' => 'price',
            'Credit Rate' => 'storecredit_rate',
            'Store Credit value' => 'storecredit_value',
            'Minimum Store Credit value' => 'storecredit_from',
            'Maximum Store Credit value' => 'storecredit_to',
            'Store Credit values' => 'storecredit_dropdown'
        ]
    ];

    public function persist(FixtureInterface $fixture = null)
    {
        $data = $this->replaceMappingData($fixture->getData());
//        throw new \Exception(var_dump($data));
        $url = $_ENV['app_backend_url'] . 'barcodesuccess/template/save/';
        $curl = new BackendDecorator(new CurlTransport(), $this->_configuration);
        $curl->write($url, $data);
        $response = $curl->read();
        $curl->close();

        if (!strpos($response, 'data-ui-id="messages-message-success"')) {
            throw new \Exception("The template has been saved successfully! Response: $response");
        }
//
//        preg_match_all('/\"template_id\":\"(\d+)\"/', $response, $matches);
//        $id = $matches[1][count($matches[1]) - 1];
        $id = $this->getTemplateId($fixture->getName());
//        throw new \Exception(var_dump($id));
        return ['template_id' => $id];
    }

    protected function getTemplateId($name)
    {
        $url = $_ENV['app_backend_url'] . 'mui/index/render/';
        $data = [
            'namespace' => 'os_barcode_template_listing',
            'filters' => [
                'placeholder' => true,
                'name' => $name
            ],
            'isAjax' => true
        ];
        $curl = new BackendDecorator(new CurlTransport(), $this->_configuration);

        $curl->write($url, $data, CurlInterface::POST);
        $response = $curl->read();
        $curl->close();

        preg_match('/os_barcode_template_listing.+items.+"template_id":"(\d+)"/', $response, $match);
        return empty($match[1]) ? null : $match[1];
    }

}