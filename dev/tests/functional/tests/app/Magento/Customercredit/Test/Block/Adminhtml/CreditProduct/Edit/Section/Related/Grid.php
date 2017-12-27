<?php
/**
 * Created by PhpStorm.
 * User: bang
 * Date: 18/12/2017
 * Time: 17:45
 */

namespace Magento\Customercredit\Test\Block\Adminhtml\CreditProduct\Edit\Section\Related;

use Magento\Catalog\Test\Block\Adminhtml\Product\Edit\Section\Related\Grid as RelatedGrid;

class Grid extends RelatedGrid
{
    public function searchAndSelect(array $filter)
    {
        $this->waitFilterToLoad();
        $this->waitDataGridLoader();
        $this->search($filter);
        $this->waitDataGridLoader();
        $rowItem = $this->getRow($filter);
        if ($rowItem->isVisible()) {
            $rowItem->find($this->selectItem)->click();
        } else {
            throw new \Exception("Searched item was not found by filter\n" . print_r($filter, true));
        }
        $this->waitLoader();
    }

    public function waitDataGridLoader()
    {
        $this->waitForElementNotVisible('[data-component="related_product_listing.related_product_listing.product_columns"]');
        $this->waitForElementNotVisible('[data-component="upsell_product_listing.upsell_product_listing.product_columns"]');
        $this->waitForElementNotVisible('[data-component="crosssell_product_listing.crosssell_product_listing.product_columns"]');
    }
}
