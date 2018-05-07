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

class WeposProductGridCheckGroupProductBlockPG36Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;


    public function __inject(
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
    }

    public function test(
        $products
    )
    {
        // Create products
        $products = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
            ['products' => $products]
        )->run();

        // Login webpos
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\SessionInstallStep'
        )->run();

        // Add product to cart
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();

        foreach ($products as $item) {
            $this->webposIndex->getCheckoutProductList()->search($item['product']->getSku());
            $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
            $this->webposIndex->getCheckoutContainer()->waitForProductDetailPopup();
            $this->webposIndex->getMainContent()->clickOutsidePopup();
            $this->webposIndex->getMsWebpos()->waitForElementNotVisible('[id="popup-product-detail"]');

        }
    }
}