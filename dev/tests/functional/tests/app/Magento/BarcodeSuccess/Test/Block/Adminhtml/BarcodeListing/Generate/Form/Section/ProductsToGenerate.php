<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 07/12/2017
 * Time: 13:18
 */
namespace Magento\BarcodeSuccess\Test\Block\Adminhtml\BarcodeListing\Generate\Form\Section;
use Magento\Mtf\Client\Element\SimpleElement;
use Magento\TestFramework\Inspection\Exception;
use Magento\Ui\Test\Block\Adminhtml\Section;
use Magento\Mtf\Client\Locator;
use Magento\BarcodeSuccess\Test\Block\Adminhtml\BarcodeListing\Generate\Form\Section\ProductsToGenerate\Grid;
/**
 * Base class for related, crosssell, upsell products.
 */
class ProductsToGenerate extends Section
{
    /**
     * Locator for 'Add Selected Products' button
     *
     * @var string
     */
    protected $gridTable = '.data-grid data-grid-draggable';
    protected $addProducts = '.action-primary[data-role="action"]';
    protected $loadingMask = '.admin__data-grid-loading-mask';
    protected $filterButton = '[data-action="grid-filter-expand"]';
    protected $spinter = '.spinter';
    protected $loadingMaskForm = '.admin__form-loading-mask';
    protected $table = '#container > div > div.entry-edit.form-inline > div:nth-child(2) > div.admin__fieldset-wrapper-content._show > fieldset > div.admin__field.admin__field-wide._no-header > div > div.admin__control-table-wrapper > table';
    public function filtersButtonIsVisible()
    {
        $this->waitForElementVisible($this->filterButton);
    }
    public function waitingForLoadingMaskNotVisible()
    {
        $this->waitForElementNotVisible($this->loadingMask, Locator::SELECTOR_CSS);
    }
    public function waitingForLoadingMaskFormNotVisible()
    {
        $this->waitForElementNotVisible($this->loadingMaskForm, Locator::SELECTOR_CSS);
    }
    /**
     * Select related products.
     *
     * @param array $data
     * @param SimpleElement|null $element
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function setFieldsData(array $data, SimpleElement $element = null)
    {
        $this->waitingForLoadingMaskNotVisible();
        $this->waitingForLoadingMaskFormNotVisible();
        $productsToGenerate = $this->getProductsToGenerateGrid($this->_rootElement->find('.modal-content'));
        $this->filtersButtonIsVisible();
        foreach ($data as $product) {
            $productsToGenerate->searchAndSelect(['sku' => $product['sku']]);
        }
        $this->_rootElement->find($this->addProducts)->click();
        sleep(4);

        return $this;
    }

    /**
     * Return related products grid.
     *
     * @param SimpleElement|null $element
     * @return Grid
     */
    protected function getProductsToGenerateGrid(SimpleElement $element = null)
    {
        $element = $element ?: $this->_rootElement;
        $result = $this->blockFactory->create(
            '\Magento\BarcodeSuccess\Test\Block\Adminhtml\BarcodeListing\Generate\Form\Section\ProductsToGenerate\Grid',
            ['element' => $element]
        );
        return $result;
    }


}
