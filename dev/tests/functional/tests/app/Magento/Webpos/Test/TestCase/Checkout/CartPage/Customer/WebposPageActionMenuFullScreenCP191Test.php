<?php
/**
 * Created by PhpStorm.
 * User: bang
 * Date: 09/01/2018
 * Time: 10:07
 */

namespace Magento\Webpos\Test\TestCase\Checkout\CartPage\Customer;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposPageActionMenuFullScreenCP191Test
 * @package Magento\Webpos\Test\TestCase\Checkout\CartPage\Customer
 *
 * Precondition:
 * "1. Login Webpos as a staff
 * 2. Add some products  to cart
 * 3. Click on [Checkout] page"
 *
 * Steps:
 * "1. Click on action menu ""..."" on the header page
 * 2. Click on ""Enter/exit fullscreen mode""
 * 3. Click on ""Enter/exit fullscreen mode"" again"
 *
 * Acceptance:
 * Exit full screen mode
 *
 */
class WebposPageActionMenuFullScreenCP191Test extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    public function __prepare()
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'webpos_default_guest_checkout_rollback']
        )->run();
    }

    /**
     * @param WebposIndex $webposIndex
     */
    public function __inject
    (
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
    }

    /**
     * @param $products
     * @return array
     */
    public function test($products)
    {
        //Create product
        $product = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
            ['products' => $products]
        )->run()[0]['product'];

        //LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        //Add product to cart
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getCheckoutProductList()->search($product->getName());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        //Cart
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();

        //Click ... Menu > click Enter/full screen
        $minHeightBeforeFull = $this->webposIndex->getBody()->getPageStyleMinHeight();

        $this->webposIndex->getCheckoutCartHeader()->getIconActionMenu()->click();
        $this->webposIndex->getCheckoutFormAddNote()->waitFullScreenMode();
        $this->webposIndex->getCheckoutFormAddNote()->getFullScreenMode()->click();
        sleep(1);
        $minHeightAfterFull = $this->webposIndex->getBody()->getPageStyleMinHeight();

        return ['minHeightBeforeFull' => $minHeightBeforeFull,
            'minHeightAfterFull' => $minHeightAfterFull,
//            'minHeightAfterAgain' => $minHeightAfterAgain
        ];
    }
}