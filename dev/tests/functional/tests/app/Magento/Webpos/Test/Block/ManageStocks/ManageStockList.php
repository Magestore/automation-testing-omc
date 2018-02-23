<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 2/1/2018
 * Time: 9:10 AM
 */

namespace Magento\Webpos\Test\Block\ManageStocks;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

class ManageStockList extends Block
{
    public function getSearchBox()
    {
        return $this->_rootElement->find('[id="search-header-stock"]');
    }

    public function searchProduct($value)
    {
        $this->getSearchBox()->setValue('');
        $this->_rootElement->find('.icon-iconPOS-search')->click();
        $this->getSearchBox()->setValue($value);
        $this->_rootElement->find('.icon-iconPOS-search')->click();
    }

    public function getProductRow($productName)
    {
        $rowTemplate = './/tr[.//span[@data-bind="text: name" and text()="%s"]]';
        return $this->_rootElement->find(sprintf($rowTemplate, $productName), Locator::SELECTOR_XPATH);
    }

    public function getProductQtyInput($productName)
    {
        $row = $this->getProductRow($productName);
        return $row->find('.qty-edit');
    }

    public function getProductQtyValue($productName)
    {
        return $this->getProductQtyInput($productName)->getValue();
    }

    public function setProductOutOfStock($productName)
    {
        $row = $this->getProductRow($productName);
        if ($row->find('[class="ios-ui-select checked"]')->isVisible()) {
            $row->find('.ios-ui-select')->click();
        }
    }

    public function setProductInStock($productName)
    {
        $row = $this->getProductRow($productName);
        $row->find('.ios-ui-select')->click();

    }

    public function getUpdateButton($productName)
    {
        $row = $this->getProductRow($productName);
        return $row->find('.update');
    }
}