<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/13/2018
 * Time: 8:57 AM
 */

namespace Magento\Webpos\Test\TestCase\ProductsGrid\BundleProduct;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposProductsGridPG34Test
 * @package Magento\Webpos\Test\TestCase\ProductsGrid\SimpleProduct
 */
class WebposProductsGridPG34Test extends Injectable
{
    /**
     * @var WebposIndex
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
     * @return array
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

        // Login webpos
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\SessionInstallStep'
        )->run();
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getCheckoutProductList()->search($products[0]['product']->getSku());

        while ( $this->webposIndex->getCheckoutProductList()->getNumberOfProducts()->getText() != 1) {
            sleep(1);
        }

        // Close popup
        if ($this->webposIndex->getCheckoutProductDetail()->isVisible()){
            $this->webposIndex->getCheckoutProductDetail()->getButtonCancel()->click();
        }

        // Click detail product
        $this->webposIndex->getCheckoutProductList()->getFirstProduct()->hover();
        $this->webposIndex->getCheckoutProductList()->getFirstProductDetailButton()->click();
        sleep(1);

        return [
            'products' => $products,
            'checkDefault' => true
        ];
    }
}