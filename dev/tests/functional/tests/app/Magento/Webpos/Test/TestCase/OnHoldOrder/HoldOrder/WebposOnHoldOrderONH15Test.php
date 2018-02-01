<?php
/**
 * Created by PhpStorm.
 * User: bang
 * Date: 26/01/2018
 * Time: 14:00
 */
namespace Magento\Webpos\Test\TestCase\OnHoldOrder\HoldOrder;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposOnHoldOrderONH15Test extends Injectable
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

    public function test($products)
    {
        //Create product
        $product1 = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
            ['products' => $products]
        )->run()[0]['product'];
        $product2 = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
            ['products' => $products]
        )->run()[1]['product'];

        //Login webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        //Create multiorder
        $this->webposIndex->getCheckoutCartHeader()->getAddMultiOrder()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getCheckoutCartHeader()->getMultiOrderItem('1')->click();
        $this->webposIndex->getMsWebpos()->waitCartLoaderVisibleToNotVisible();

        //Add a taxable products to cart
        $this->webposIndex->getCheckoutProductList()->search($product1->getName());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        sleep(1);
        $this->webposIndex->getCheckoutCartHeader()->getMultiOrderItem('2')->click();
        $this->webposIndex->getMsWebpos()->waitCartLoaderVisibleToNotVisible();
        $this->webposIndex->getCheckoutProductList()->search($product2->getName());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        sleep(1);
        $this->webposIndex->getCheckoutCartHeader()->getMultiOrderItem('1')->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        sleep(4);

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