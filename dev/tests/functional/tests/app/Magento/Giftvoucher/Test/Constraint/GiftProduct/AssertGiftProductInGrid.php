<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/12/2017
 * Time: 8:56 AM
 */

namespace Magento\Giftvoucher\Test\Constraint\GiftProduct;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Catalog\Test\Page\Adminhtml\CatalogProductIndex;
use Magento\Mtf\Fixture\FixtureInterface;

class AssertGiftProductInGrid extends AbstractConstraint
{
    /**
     * Product fixture.
     *
     * @var FixtureInterface $product
     */
    protected $product;

    /**
     * Assert that product is present in products grid and can be found by sku, type, status and attribute set.
     *
     * @param FixtureInterface $product
     * @param CatalogProductIndex $productIndex
     * @return void
     */
    public function processAssert(FixtureInterface $product, CatalogProductIndex $productIndex)
    {
        $this->product = $product;
        $productIndex->open();
        $productIndex->getProductGrid()->resetFilter();
        \PHPUnit_Framework_Assert::assertTrue(
            $productIndex->getProductGrid()->isRowVisible($this->prepareFilter()),
            'Product \'' . $this->product->getName() . '\' is absent in Products grid.'
        );
    }

    /**
     * Prepare filter for product grid.
     *
     * @return array
     */
    protected function prepareFilter()
    {
        $productStatus = ($this->product->getStatus() === null || $this->product->getStatus() === 'Yes')
            ? 'Enabled'
            : 'Disabled';
        $filter = [
            'type' => $this->getProductType(),
            'sku' => $this->product->getSku(),
            'status' => $productStatus,
        ];
        if ($this->product->hasData('attribute_set_id')) {
            $filter['set_name'] = $this->product->getAttributeSetId();
        }

        return $filter;
    }

    /**
     * Get product type.
     *
     * @return string
     */
    protected function getProductType()
    {
        return 'Gift Card';
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Product is present in products grid.';
    }
}