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
    }

    public function getProductRow($productName)
    {
        $rowTemplate = './/tr[.//span[@data-bind="text: name" and text()="%s"]]';
        return $this->_rootElement->find(sprintf($rowTemplate, $productName), Locator::SELECTOR_XPATH);
    }

    public function getProductQtyInput($productName)
    {
        $row = $this->getProductRow($productName);
        return $row->find('input.qty-edit');
    }

    public function getProductQtyValue($productName)
    {
        return $this->getProductQtyInput($productName)->getValue();
    }

    public function getInStockSwitchByProduct($productName)
    {
        return $this->getProductRow($productName)->find('.ios-ui-select');
    }

    public function getUpdateButtonByProduct($productName)
    {
        return $this->getProductRow($productName)->find('.update');
    }

    public function getUpdateSuccessByProduct($productName)
    {
        return $this->getProductRow($productName)->find('.icon-iconPOS-success');
    }
}