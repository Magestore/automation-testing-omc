<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 2/12/2018
 * Time: 1:33 PM
 */

namespace Magento\Webpos\Test\TestCase\ProductsGrid\GroupProduct;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WeposProductGridCheckGroupProductBlockPG36Test
 * @package Magento\Webpos\Test\TestCase\ProductsGrid\GroupProduct
 *
 * Precondition:
 * 1. Login webpos as a staff
 *
 * Steps:
 * 1. Check Group product block
 *
 * Acceptance:
 * "1.
 * - Display correctly image, name of the product
 * - Don't show Available  Qty on the product block
 * - Product price = 0"
 *
 */
class WeposProductGridCheckGroupProductBlockPG36Test extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * @param WebposIndex $webposIndex
     */
    public function __inject(
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
    }

    /**
     * @param $products
     */
    public function test(
        $products
    )
    {
        // Create products
        $products = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
            ['products' => $products]
        )->run();

        // LoginTest webpos
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\SessionInstallStep'
        )->run();

        // Add product to cart
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();

        foreach ($products as $item) {
            $this->webposIndex->getCheckoutProductList()->search($item['product']->getSku());
            $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
            $this->webposIndex->getCheckoutContainer()->waitForProductDetailPopup();
            $this->webposIndex->getCheckoutProductDetail()->getButtonCancel()->click();
            $this->webposIndex->getMsWebpos()->waitForElementNotVisible('[id="popup-product-detail"]');

        }
    }
}