<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/5/2018
 * Time: 3:35 PM
 */

namespace Magento\Webpos\Test\TestCase\ProductsGrid\SimpleProduct;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposProductsGridCheckGUISimpleProductTest
 * @package Magento\Webpos\Test\TestCase\ProductsGrid\SimpleProduct
 *
 * PG02
 * Precondition:
 * 1. Login webpos as a staff
 *
 * Steps:
 * 1. Check simple product block
 *
 * Acceptance:
 * 1. Display correctly image, name of the product
 *
 * PG04
 * Precondition:
 * 1. Login webpos as a staff
 *
 * Steps:
 * 1. Check product Qty  on the Product grid
 *
 * Acceptance:
 * 1. Show: "Availability: 0 item(s)"
 *
 */
class WebposProductsGridCheckGUISimpleProductTest extends Injectable
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

        $this->webposIndex->open();

        if ($this->webposIndex->getLoginForm()->isVisible()) {
            // LoginTest webpos
            $this->objectManager->getInstance()->create(
                'Magento\Webpos\Test\TestStep\SessionInstallStep'
            )->run();
        }

        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();

        $this->webposIndex->getCheckoutProductList()->search($products[0]['product']->getSku());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        return [
            'products' => $products
        ];
    }
}