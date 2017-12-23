<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 07/12/2017
 * Time: 13:21
 */

namespace Magento\BarcodeSuccess\Test\Block\Adminhtml\BarcodeListing\Generate\Form\Section\ProductsToGenerate;
use Magento\TestFramework\Inspection\Exception;
use Magento\Ui\Test\Block\Adminhtml\DataGrid;

/**
 * Barcode generate grid.
 */
class Grid extends DataGrid
{
    /**
     * Grid fields map
     *
     * @var array
     */
    protected $filters = [
        'sku' => [
            'selector' => 'input[name="sku"]',
        ]
    ];
    public function searchAndSelect(array $filter)
    {
        $this->waitLoader();
        $this->waitForElementNotVisible('.admin__data-grid-loading-mask');
        $this->waitForElementNotVisible('.admin__form-loading-mask');
        $this->search($filter);
        $rowItem = $this->getRow($filter);
        if ($rowItem->isVisible()) {
            sleep(3);
            $rowItem->find($this->selectItem)->click();
        } else {
            throw new \Exception("Searched item was not found by filter\n" . print_r($filter, true));
        }
        $this->waitLoader();
    }
    protected function openFilterBlock()
    {
        $this->waitFilterToLoad();

        $toggleFilterButton = $this->_rootElement->find($this->filterButton);
        $searchButton = $this->_rootElement->find($this->searchButton);
        if ($toggleFilterButton->isVisible() && !$searchButton->isVisible()) {
            sleep(1);
            $toggleFilterButton->click();
            $browser = $this->_rootElement;
            $browser->waitUntil(
                function () use ($searchButton) {
                    return $searchButton->isVisible() ? true : null;
                }
            );
        }
    }

}
