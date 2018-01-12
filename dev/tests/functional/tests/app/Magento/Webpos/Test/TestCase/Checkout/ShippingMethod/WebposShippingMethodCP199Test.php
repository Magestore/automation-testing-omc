<?php
/**
 * Created by PhpStorm.
 * User: bang
 * Date: 12/01/2018
 * Time: 16:38
 */
namespace Magento\Webpos\Test\TestCase\Checkout\ShippingMethod;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;
class WebposShippingMethodCP199Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;
    public function __inject
    (
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
    }

    public function test($productCustom)
    {
        //Login webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        //Add product custom sale
        $this->webposIndex->getCheckoutProductList()->getCustomSaleButton()->click();
        $this->webposIndex->getCheckoutCustomSale()->getProductNameInput()->setValue($productCustom['name']);
        $this->webposIndex->getCheckoutCustomSale()->getProductPriceInput()->setValue($productCustom['price']);
        $this->webposIndex->getCheckoutCustomSale()->getAddToCartButton()->click();
        sleep(1);

        //Checkout
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(1);
    }
}