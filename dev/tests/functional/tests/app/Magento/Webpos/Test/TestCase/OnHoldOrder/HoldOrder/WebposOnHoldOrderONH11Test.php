<?php
/**
 * Created by PhpStorm.
 * User: bang
 * Date: 26/01/2018
 * Time: 13:26
 */
namespace Magento\Webpos\Test\TestCase\OnHoldOrder\HoldOrder;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposOnHoldOrderONH11Test
 * @package Magento\Webpos\Test\TestCase\OnHoldOrder\HoldOrder
 */
class WebposOnHoldOrderONH11Test extends Injectable
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

    public function test($products, $discount)
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

        //Click on [Add discount] > on Discount tab, add dicount for whole cart (type: $)
        while (!$this->webposIndex->getCheckoutDiscount()->isDisplayPopup())
        {
            $this->webposIndex->getCheckoutCartFooter()->getAddDiscount()->click();
        }
        $this->webposIndex->getCheckoutDiscount()->clickDiscountButton();
        $this->webposIndex->getCheckoutDiscount()->setTypeDiscount('$');
        $this->webposIndex->getCheckoutDiscount()->setNumberDiscount($discount);
        $this->webposIndex->getCheckoutDiscount()->clickDiscountApplyButton();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(1);

        //Hold
        $this->webposIndex->getCheckoutCartFooter()->getButtonHold()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(2);

        $dataProduct = $product->getData();
        $dataProduct['qty'] = '1';
        return ['products' => [$dataProduct],
            'discount'=> $discount
        ];
    }
}