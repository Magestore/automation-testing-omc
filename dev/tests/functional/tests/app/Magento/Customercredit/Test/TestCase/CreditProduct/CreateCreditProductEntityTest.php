<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 12/1/2017
 * Time: 2:30 PM
 */

namespace Magento\Customercredit\Test\TestCase\CreditProduct;

use Magento\Customercredit\Test\Fixture\CreditProduct;
use Magento\Customercredit\Test\Page\Adminhtml\CreditProductIndex;
use Magento\Customercredit\Test\Page\Adminhtml\CreditProductNew;
use Magento\Catalog\Test\Fixture\Category;
use Magento\Mtf\TestCase\Injectable;

/**
 * Steps:
 * 1. Login to the backend.
 * 2. Navigate to Store Credit > Manage Credit Products.
 * 3. Start to create credit product.
 * 4. Fill in data according to data set.
 * 5. Save Product.
 * 6. Perform appropriate assertions.
 *
 */
class CreateCreditProductEntityTest extends Injectable
{
    /**
     * @var CreditProductIndex
     */
    protected $creditProductIndex;

    /**
     * @var CreditProductNew
     */
    protected $creditProductNew;

    public function testCreate(
        CreditProduct $product,
        CreditProductIndex $productGrid,
        CreditProductNew $newProductPage
    ) {
        // Steps
        $productGrid->open();
        $productGrid->getCreditProductGridPageActions()->clickActionButton('add');
        $newProductPage->getCreditProductForm()->fill($product);
        $newProductPage->getCreditProductFormPageAction()->save();
        return ['product' => $product];
    }
}