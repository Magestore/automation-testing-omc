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

//    public function __prepare(Category $category)
//    {
//        $category->persist();
//
//        return [
//            'category' => $category
//        ];
//    }

//    public function __prepare(CreditProduct $creditProduct)
//    {
//        $creditProduct->persist();
//    }

    public function testCreate(
        CreditProduct $product,
//        Category $category,
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