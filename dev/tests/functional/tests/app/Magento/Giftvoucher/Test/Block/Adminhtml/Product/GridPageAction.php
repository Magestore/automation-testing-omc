<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Giftvoucher\Test\Block\Adminhtml\Product;

use Magento\Backend\Test\Block\GridPageActions as ParentGridPageActions;
use Magento\Mtf\Client\Locator;

/**
 * Catalog manage products block.
 */
class GridPageAction extends ParentGridPageActions
{
    /**
     * Product toggle button.
     *
     * @var string
     */
    protected $toggleButton = '[data-ui-id=products-list-add-new-product-button-dropdown]';

    /**
     * Product type item.
     *
     * @var string
     */
    protected $productItem = '[data-ui-id=products-list-add-new-product-button-item-%productType%]';

    /**
     * Product type list.
     *
     * @var string
     */
    protected $typeList = '[data-ui-id=products-list-add-new-product-button-dropdown-menu]';

    /**
     * Magento spinner selector.
     *
     * @var string
     */
    protected $spinner = '[data-role="spinner"]';

    protected $addProductButton = 'add_new_product';

    /**
     * Add product using split button.
     *
     * @param string $productType
     * @return void
     */
    public function addProduct($productType = 'giftvoucher')
    {
        $this->waitForElementNotVisible($this->spinner);
        $this->_rootElement->find($this->addProductButton, Locator::SELECTOR_ID)->click();
    }

    public function getAddGiftCardProduct()
    {
        return $this->_rootElement->find($this->addProductButton, Locator::SELECTOR_ID);
    }

  /**
     * Get product list.
     *
     * @return array
     */
    public function getTypeList()
    {
        $this->_rootElement->find($this->toggleButton, Locator::SELECTOR_CSS)->click();
        return $this->_rootElement->find(
            $this->typeList,
            Locator::SELECTOR_CSS
        )->getText();
    }
}
