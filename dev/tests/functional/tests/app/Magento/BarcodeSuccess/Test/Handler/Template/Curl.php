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

/**
 * Curl handler for creating templateInstance/backendApp.
 */
class Curl extends AbstractCurl
{
    /**
     * Mapping values for data.
     *
     * @var array
     */
//    protected $mappingData = [
//        'code' => [
//            'CMS Page Link' => 'cms_page_link',
//        ],
//        'block' => [
//            'Main Content Area' => 'content',
//            'Sidebar Additional' => 'sidebar.additional',
//            'Sidebar Main' => 'sidebar.main',
//        ]
//    ];

    /**
     * Post request for creating widget instance.
     *
     * @param FixtureInterface $fixture [optional]
     * @throws \Exception
     * @return null|array instance id
     */
    public function persist(FixtureInterface $fixture = null)
    {
        // Prepare data to send it using cURL.
//        $data = $this->prepareData($fixture);
        // Build url to send post request to create widget.
        $data = $this->replaceMappingData($fixture->getData());
        $data['form_key'] = 'fasdfadsfsad';
        $url = $_ENV['app_backend_url'] . 'admin/barcodesuccess/template/save/';
        // Create CurlTransport instance to operate with cURL. BackendDecorator is used to log in to Magento backend.
        $curl = new BackendDecorator(new CurlTransport(), $this->_configuration);
        // Send request to url with prepared data.
        $curl->write($url, $data);
        // Read response.
        $response = $curl->read();
        // Close connection to server.
        $curl->close();
        // Verify whether request has been successful (check if success message is present).
        if (!strpos($response, 'data-ui-id="messages-message-success"')) {
            throw new \Exception("The template has been saved successfully! Response: $response");
        }
//        // Get id of created widget in order to use in other tests.
//        $id = null;
//        if (preg_match_all('/\/widget_instance\/edit\/instance_id\/(\d+)/', $response, $matches)) {
//            $id = $matches[1][count($matches[1]) - 1];
//        }
//        return ['id' => $id];
    }

    /**
     * Prepare data to create template.
     *
     * @param FixtureInterface $template
     * @return array
     */
//    protected function prepareData(FixtureInterface $template)
//    {
//        // Replace UI fixture values with values that are applicable for cURL. Property $mappingData is used.
//        $data = $this->replaceMappingData($template->getData());
//        // Perform data manipulations to prepare the cURL request based on input data.
//        ...
//        return $data;
//    }
    // Additional methods.
}