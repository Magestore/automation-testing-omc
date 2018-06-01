<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/5/2018
 * Time: 1:34 PM
 */

namespace Magento\Webpos\Test\TestCase\ProductsGrid\CheckGUI;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposProductsGridCheckGUITest
 * @package Magento\Webpos\Test\TestCase\ProductsGrid\CheckGUI
 *
 * Precondition:
 * 1. Login webpos as a staff
 *
 * Steps:
 * 1. Check GUI of product grid
 *
 * Acceptance:
 * "1. Product grid displays on the left of webpos including:
 * - On header: Search textbox, Category
 * - Product block with: product image, product name, product price, [View product details] button
 * - On footer: number of products, page number, Custom sale"
 *
 */
class WebposProductsGridCheckGUITest extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * @param WebposIndex $webposIndex
     */
    public function __inject(WebposIndex $webposIndex)
    {
        $this->webposIndex = $webposIndex;
    }

    /**
     *
     */
    public function test()
    {
        // LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\SessionInstallStep'
        )->run();

        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getCheckoutProductList()->getFirstProduct()->hover();
    }
}