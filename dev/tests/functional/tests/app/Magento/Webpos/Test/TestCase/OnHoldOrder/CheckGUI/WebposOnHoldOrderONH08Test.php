<?php
/**
 * Created by PhpStorm.
 * User: bang
 * Date: 26/01/2018
 * Time: 13:26
 */
namespace Magento\Webpos\Test\TestCase\OnHoldOrder\CheckGUI;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposOnHoldOrderONH08Test extends Injectable
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

    public function test($products, $priceCustom)
    {
        //Create product
        $product = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
            ['products' => $products]
        )->run()[0]['product'];

        //Login webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        //Create a on-hold-order
            //Add a product to cart
        $this->webposIndex->getCheckoutProductList()->search($product->getName());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        sleep(1);
            //Edit customer price of that product with type: $
        $this->webposIndex->getCheckoutCartItems()->getFirstCartItem()->click();
        if (!$this->webposIndex->getCheckoutProductEdit()->getPanelPriceBox()->isVisible())
        {
            $this->webposIndex->getCheckoutProductEdit()->getCustomPriceButton()->click();
        }
        $this->webposIndex->getCheckoutProductEdit()->getPercentButton()->click();
        $this->webposIndex->getCheckoutProductEdit()->getAmountInput()->setValue($priceCustom);
        sleep(1);
        $this->webposIndex->getMsWebpos()->clickOutsidePopup();
            //Hold
        $this->webposIndex->getCheckoutCartFooter()->getButtonHold()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(1);

        //Click on On-hold Orders menu
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->onHoldOrders();
        sleep(1);
        $this->webposIndex->getOnHoldOrderOrderList()->waitLoader();
    }
}