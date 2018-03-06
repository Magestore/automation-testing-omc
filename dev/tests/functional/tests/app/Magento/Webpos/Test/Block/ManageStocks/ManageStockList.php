<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 2/1/2018
 * Time: 9:10 AM
 */

namespace Magento\Webpos\Test\Block\ManageStocks;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\ElementInterface;
use Magento\Mtf\Client\Locator;

class ManageStockList extends Block
{
    public function getSearchBox()
    {
        return $this->_rootElement->find('[id="search-header-stock"]');
    }

    public function searchProduct($value)
    {
//        $this->getSearchBox()->setValue('');
//        $this->_rootElement->find('.icon-iconPOS-search')->click();
        $this->getSearchBox()->setValue($value);
//        $this->_rootElement->find('.icon-iconPOS-search')->click();
	    sleep(2);
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
		return $this->_rootElement->find('.table-product tbody tr td.a-left span')->getText();
	}

	public function getFirstProductRow()
	{
		return $this->_rootElement->find('.table-product tbody tr:nth-child(1)');
	}

	/**
	 * @param ElementInterface $divCheckbox
	 * @return bool|int
	 */
	public function isCheckboxChecked($divCheckbox)
	{
		$class = $divCheckbox->find('div')->getAttribute('class');
		return strpos($class, 'checked');
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
		$products = $this->_rootElement->getElements('.table-product tbody tr');
		return count($products);
	}

	public function waitForProductIconSuccess($productName)
	{
		$selector = './/tr[.//span[@data-bind="text: name" and text()="%s"]].//span[@class="icon-iconPOS-success"]';
		$this->waitForElementVisible(sprintf($selector, $productName), Locator::SELECTOR_XPATH);
	}
}