<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/27/2017
 * Time: 1:10 PM
 */

namespace Magento\Storepickup\Test\Block\Adminhtml\Store\ImportStore;

use Magento\Mtf\Block\Form;
use Magento\Mtf\Client\Locator;
use Magento\Mtf\Util\Protocol\CurlTransport;
use Magento\Mtf\Util\Protocol\CurlTransport\BackendDecorator;
use Magento\Mtf\Client\BrowserInterface;
use Magento\Mtf\Client\Element\SimpleElement;
use Magento\Mtf\Util\ModuleResolver\SequenceSorterInterface;
use Magento\Mtf\Config\DataInterface;
use Magento\Mtf\Block\BlockFactory;
use Magento\Mtf\Block\Mapper;

/**
 * Class StoreImportStoreForm
 * @package Magento\Storepickup\Test\Block\Adminhtml\Store\ImportStore
 */
class StoreImportStoreForm extends Form
{
    /**
     * @var string
     */
    protected $importStoreTitle = './/span[text()="Import Information"]';

    /**
     * @var string
     */
    protected $importFileField = '[data-ui-id="storepickup-store-import-form-fieldset-element-form-field-filecsv"]';

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
    protected $sampleLink = '#filecsv-note a';

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
     * @return mixed
     */
    public function importStoreTitleIsVisible()
    {
        return $this->_rootElement->find($this->importStoreTitle, Locator::SELECTOR_XPATH)->isVisible();
    }

    /**
     * @return mixed
     */
    public function importFileFieldIsVisible()
    {
        return $this->_rootElement->find($this->importFileField, Locator::SELECTOR_CSS)->isVisible();
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