<?php

namespace Magento\Giftvoucher\Test\Block\Adminhtml\Block\Giftcode;

use Magento\Backend\Test\Block\Widget\FormTabs;
use Magento\Mtf\Util\Protocol\CurlTransport;
use Magento\Mtf\Util\Protocol\CurlTransport\BackendDecorator;
use Magento\Mtf\Client\BrowserInterface;
use Magento\Mtf\Client\Element\SimpleElement;
use Magento\Mtf\Util\ModuleResolver\SequenceSorterInterface;
use Magento\Mtf\Config\DataInterface;
use Magento\Mtf\Block\BlockFactory;
use Magento\Mtf\Block\Mapper;

/**
 * Backend Import Form for Giftcode
 */
class ImportForm extends FormTabs
{
    /**
     * Configuration parameters array.
     *
     * @var DataInterface
     */
    protected $_configuration;

    /**
     * "Sample" link
     *
     * @var string
     */
    protected $sampleLink = '#sample a';

    /**
     * Input file
     *
     * @var string
     */
    protected $filecsv = '#filecsv';

    public function __construct(
        SimpleElement $element,
        BlockFactory $blockFactory,
        Mapper $mapper,
        BrowserInterface $browser,
        SequenceSorterInterface $sequenceSorter,
        DataInterface $configuration,
        array $config = []
    ) {
        $this->_configuration = $configuration;
        parent::__construct($element, $blockFactory, $mapper, $browser, $sequenceSorter, $config);
    }

    /**
     * Sample Link
     *
     * @return string
     */
    public function getSampleLink()
    {
        return $this->_rootElement->find($this->sampleLink)->getAttribute('href');
    }

    /**
     * Download sample file
     *
     * @param string $filename Path to save file
     */
    public function downloadSample($filename)
    {
        $curl = new BackendDecorator(new CurlTransport(), $this->_configuration);
        $curl->write($this->getSampleLink());
        $response = $curl->read();
        $curl->close();
        // Write to file
        file_put_contents($filename, $response);
    }

    /**
     * Fill csv form file
     *
     * @param string $filename
     */
    public function fillCsvFormFile($filename)
    {
        $this->_rootElement->find($this->filecsv)->setValue(
            getcwd() . DIRECTORY_SEPARATOR . $filename
        );
    }
}
