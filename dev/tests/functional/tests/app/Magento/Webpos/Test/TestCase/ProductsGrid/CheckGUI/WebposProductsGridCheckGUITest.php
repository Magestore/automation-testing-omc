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