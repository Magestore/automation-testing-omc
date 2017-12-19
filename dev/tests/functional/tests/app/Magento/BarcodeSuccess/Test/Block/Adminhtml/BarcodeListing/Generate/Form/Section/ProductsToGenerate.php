<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 07/12/2017
 * Time: 13:18
 */

namespace Magento\BarcodeSuccess\Test\Block\Adminhtml\BarcodeListing\Generate\Form\Section;

use Magento\Mtf\Client\Element\SimpleElement;
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
    protected $addProducts = '.action-primary[data-role="action"]';

    protected $filterButton = '[data-action="grid-filter-expand"]';
    protected $spinter = '.spinter';
    protected $table = '#container > div > div.entry-edit.form-inline > div:nth-child(2) > div.admin__fieldset-wrapper-content._show > fieldset > div.admin__field.admin__field-wide._no-header > div > div.admin__control-table-wrapper > table';
    public function filtersButtonIsVisible()
    {
        $this->waitForElementVisible($this->filterButton);
    }
    public function waitingForLoadingSpinterNotVisible()
    {
//        $this->waitLoader();
        $this->waitForElementNotVisible($this->spinter);
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
        $this->_rootElement->find('[data-index="grouped_products_button"]')->click();
        $context = $this->browser->find('.os_barcode_generate_form_os_barcode_generate_form_os_generate_barcode_generate_products_modal');
        $productsToGenerate = $this->getProductsToGenerateGrid($context);
        $this->waitingForLoadingSpinterNotVisible();
        $this->filtersButtonIsVisible();
        foreach ($data as $product) {
            $productsToGenerate->searchAndSelect(['sku' => $product['sku']]);
        }
        $context->find($this->addProducts)->click();
        $this->waitForElementVisible($this->table);
        return $this;
    }

    /**
     * Get data of section.
     *
     * @param array|null $fields
     * @param SimpleElement|null $element
     * @return array
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
//    public function getFieldsData($fields = null, SimpleElement $element = null)
//    {
//        $relatedProducts = array_keys($fields);
//        $data = [];
//        foreach ($relatedProducts as $relatedProduct) {
//            $relatedTypeUnderscore = substr($relatedProduct, 0, strpos($relatedProduct, '_products'));
//            $relatedType = str_replace('_', '', $relatedTypeUnderscore);
//            $context = $this->browser->find('[data-index="' . $relatedType . '"]');
//            $relatedBlock = $this->getRelatedGrid($context);
//            $columns = ['id', 'name', 'sku'];
//            $relatedProducts = $relatedBlock->getRowsData($columns);
//            $data = [$relatedProduct => $relatedProducts];
//        }
//
//        return $data;
//    }

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
