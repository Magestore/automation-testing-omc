<?php
/**
 * Created by PhpStorm.
 * User: bang
 * Date: 26/01/2018
 * Time: 13:26
 */

namespace Magento\Webpos\Test\TestCase\OnHoldOrder\ProcessingOnHoldOrder;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposOnHoldOrderONH19Test
 * @package Magento\Webpos\Test\TestCase\OnHoldOrder\ProcessingOnHoldOrder
 * Precondition and setup steps:
 * 1. Login Webpos as a staff
 * 2. Create an on-hold order successfully with custom product and custom price
 * Steps:
 * 1. Go to On-Hold Orders menu
 * 2. Click on [Checkout] button on that on-hold order
 * Acceptance Criteria:
 * - Custom price and custom product will be loaded to cart page successfully
 */
class WebposOnHoldOrderONH19Test extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

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
     * @param $productCustom
     * @param $priceCustom
     * @return array
     */
    public function test($productCustom, $priceCustom)
    {
        //LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();
        //Create a on-hold-order
        //Add product custom sale
        $this->webposIndex->getCheckoutProductList()->getCustomSaleButton()->click();
        $this->webposIndex->getCheckoutCustomSale()->getProductNameInput()->setValue($productCustom['name']);
        $this->webposIndex->getCheckoutCustomSale()->getProductPriceInput()->setValue($productCustom['price']);
        $this->webposIndex->getCheckoutCustomSale()->getAddToCartButton()->click();
        sleep(1);
        //Edit customer price of that product with type: $
        $this->webposIndex->getCheckoutCartItems()->getFirstCartItem()->click();
        if (!$this->webposIndex->getCheckoutProductEdit()->getPanelPriceBox()->isVisible()) {
            $this->webposIndex->getCheckoutProductEdit()->getCustomPriceButton()->click();
        }
        $this->webposIndex->getCheckoutProductEdit()->getDollarButton()->click();
        $this->webposIndex->getCheckoutProductEdit()->getAmountInput()->setValue($priceCustom);
        $this->webposIndex->getCheckoutProductEdit()->getClosePopupCustomerSale()->click();
        sleep(1);
        //Hold
        $this->webposIndex->getCheckoutCartFooter()->getButtonHold()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        //Cart in On-Hold
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->onHoldOrders();
        $this->webposIndex->getOnHoldOrderOrderList()->waitLoader();
        $this->webposIndex->getOnHoldOrderOrderList()->getFirstOrder()->click();
        $this->webposIndex->getOnHoldOrderOrderViewFooter()->getCheckOutButton()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(1);
        $dataProduct = $productCustom;
        $dataProduct['qty'] = 1;
        return [
            'cartProducts' => [$dataProduct],
            'type' => '$'
        ];
    }
}