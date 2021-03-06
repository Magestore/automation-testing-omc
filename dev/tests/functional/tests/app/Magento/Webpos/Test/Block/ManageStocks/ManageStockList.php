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

    public function getProductName($productName)
    {
        $row = $this->getProductRow($productName);
        return $row->find('span[data-bind="text: name"]');
    }

    public function getProductSku($productName)
    {
        $row = $this->getProductRow($productName);
        return $row->find('span[data-bind="text: sku"]');
    }

    public function getProductInStockCheckbox($productName)
    {
        $row = $this->getProductRow($productName);
        return $row->find('td:nth-child(4)');
    }

    public function getProductManageStocksCheckbox($productName)
    {
        $row = $this->getProductRow($productName);
        return $row->find('td:nth-child(5)');
    }

    public function getProductBackOrdersCheckbox($productName)
    {
        $row = $this->getProductRow($productName);
        return $row->find('td:nth-child(6)');
    }

    public function getProductIconSuccess($productName)
    {
        $row = $this->getProductRow($productName);
        return $row->find('.icon-iconPOS-success');
    }

    public function getFirstProductName()
    {
        $this->waitForProductListShow();
        return $this->_rootElement->find('.table-product tbody tr td.a-left span')->getText();
    }

    public function getFirstProductRow()
    {
        return $this->_rootElement->find('.table-product tbody tr:nth-child(1)');
    }

    public function waitFirstProductRowVisible()
    {
        return $this->waitForElementVisible('.table-product tbody tr:nth-child(1)');
    }

    /**
     * @param ElementInterface $divCheckbox
     * @return bool|int
     */
    public function isCheckboxChecked($divCheckbox)
    {
        $class = $divCheckbox->find('div')->getAttribute('class');
        if (strpos($class, 'checked') !== false) {
            return true;
        }
        return false;
    }

    /**
     * @param ElementInterface $divCheckbox
     * @param bool $value
     */
    public function setCheckboxValue($divCheckbox, $value)
    {
        if ($divCheckbox->isVisible()) {
            if ($value != $this->isCheckboxChecked($divCheckbox)) {
                $divCheckbox->click();
            }
        }
    }

    public function getUpdateAllButton()
    {
        return $this->_rootElement->find('th.a-right a');
    }

    public function countProductRows()
    {
        $this->waitForProductListShow();
        $products = $this->_rootElement->getElements('.table-product tbody tr');
        return count($products);
    }

    public function waitForProductIconSuccess($productName)
    {
        $selector = './/tr[.//span[@data-bind="text: name" and text()="%s"]]//span[@class="icon-iconPOS-success"]';
        $this->waitForElementVisible(sprintf($selector, $productName), Locator::SELECTOR_XPATH);
    }

    public function getStoreAddress()
    {
        return $this->_rootElement->find('.sum-info-top .address');
    }

    public function waitForProductListShow()
    {
        $this->waitForElementVisible('.table-product tbody tr:first-child');
    }

    public function getInStockSwitchByProduct($productName)
    {
        return $this->getProductRow($productName)->find('.ios-ui-select');
    }

    public function getManageStockSwitchByProduct($productName)
    {
        return $this->getProductManageStocksCheckbox($productName)->find('.ios-ui-select');
    }

    public function getBackOrdersSwitchByProduct($productName)
    {
        return $this->getProductBackOrdersCheckbox($productName)->find('.ios-ui-select');
    }

    public function getUpdateButtonByProduct($productName)
    {
        return $this->getProductRow($productName)->find('.update');
    }

    public function getUpdateSuccessByProduct($productName)
    {
        return $this->getProductRow($productName)->find('.icon-iconPOS-success');
    }

    public function resetSearchProduct()
    {
        $this->getSearchBox()->setValue('');
    }

    public function getInStockValueByProduct($productName)
    {
        $inStock = $this->getInStockSwitchByProduct($productName);
        if (strpos($inStock->getAttribute('class'), 'checked') !== false) {
            return true;
        }
        return false;
    }

    public function getManageStockValueByProduct($productName)
    {
        $inStock = $this->getManageStockSwitchByProduct($productName);
        if (strpos($inStock->getAttribute('class'), 'checked') !== false) {
            return true;
        }
        return false;
    }

    public function getBackOrdersValueByProduct($productName)
    {
        $inStock = $this->getBackOrdersSwitchByProduct($productName);
        if (strpos($inStock->getAttribute('class'), 'checked') !== false) {
            return true;
        }
        return false;
    }
}