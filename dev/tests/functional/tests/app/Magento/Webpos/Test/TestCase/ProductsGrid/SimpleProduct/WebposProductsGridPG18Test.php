<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/8/2018
 * Time: 1:42 PM
 */

namespace Magento\Webpos\Test\TestCase\ProductsGrid\SimpleProduct;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposProductsGridPG18Test
 * @package Magento\Webpos\Test\TestCase\ProductsGrid\SimpleProduct
 */
class WebposProductsGridPG18Test extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * @param WebposIndex $webposIndex
     */
    public function __inject(WebposIndex $webposIndex)
    {
        $this->webposIndex = $webposIndex;
    }

    public function test()
    {
        // LoginTest webpos
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\SessionInstallStep'
        )->run();

        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();

        $this->webposIndex->getCheckoutProductList()->getFirstProduct()->hover();
        $this->webposIndex->getCheckoutProductList()->getFirstProductDetailButton()->click();
        $this->webposIndex->getCheckoutProductDetail()->getButtonCancel()->click();

    }
}