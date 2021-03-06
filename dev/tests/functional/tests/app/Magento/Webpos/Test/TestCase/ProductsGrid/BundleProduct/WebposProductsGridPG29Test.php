<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/12/2018
 * Time: 10:49 AM
 */

namespace Magento\Webpos\Test\TestCase\ProductsGrid\BundleProduct;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposProductsGridPG29Test
 * @package Magento\Webpos\Test\TestCase\ProductsGrid\BundleProduct
 *
 * Precondition:
 * 1. Login webpos as a staff
 *
 * Steps:
 * 1. Check bundle product block
 *
 * Acceptance:
 * "1.
 * - Display correctly image, name of the product
 * - Don't show Available  Qty on the product block
 * - Product price = 0"
 *
 */
class WebposProductsGridPG29Test extends Injectable
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

        // LoginTest webpos
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\SessionInstallStep'
        )->run();

        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getCheckoutProductList()->search($products[0]['product']->getSku());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        /** wait render popup */
        sleep(2);
        if ($this->webposIndex->getCheckoutProductDetail()->isVisible()) {
            $this->webposIndex->getCheckoutProductDetail()->getButtonCancel()->click();
        }

        return [
            'products' => $products
        ];
    }
}