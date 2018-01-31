<?php
/**
 * Created by PhpStorm.
 * User: bang
 * Date: 26/01/2018
 * Time: 13:26
 */
namespace Magento\Webpos\Test\TestCase\OnHoldOrder\Search;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Webpos\Test\Constraint\Checkout\HoldOrder\AssertCheckOnHoldOrderEmpty;

class WebposOnHoldOrderONH28Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;
    /**
     * @var AssertCheckOnHoldOrderEmpty
     */
    protected $assertCheckEmpty;

    public function __inject
    (
        WebposIndex $webposIndex,
        AssertCheckOnHoldOrderEmpty $assertCheckEmpty
    )
    {
        $this->webposIndex = $webposIndex;
        $this->assertCheckEmpty = $assertCheckEmpty;
    }

    public function test($products)
    {
        //Create product
        $products = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
            ['products' => $products]
        )->run();
        $product1 = $products[0]['product'];
        $product2 = $products[1]['product'];
        $product3 = $products[2]['product'];

        //Login webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        //Create a on-hold-order
            //Add a product to cart
        $this->webposIndex->getCheckoutProductList()->search($product1->getName());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        sleep(1);
            //Hold
        $this->webposIndex->getCheckoutCartFooter()->getButtonHold()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(1);

        //Get idOrder1
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->onHoldOrders();
        sleep(1);
        $idOrder1 = $this->webposIndex->getOnHoldOrderOrderList()->getIdFirstOrder();
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->checkout();
        sleep(1);

        //Create other on-hold-order
            //Add a product to cart
        $this->webposIndex->getCheckoutProductList()->search($product2->getName());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        sleep(1);
            //Hold
        $this->webposIndex->getCheckoutCartFooter()->getButtonHold()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(1);

        //Create another on-hold-order
            //Add a product to cart
        $this->webposIndex->getCheckoutProductList()->search($product3->getName());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        sleep(1);
            //Hold
        $this->webposIndex->getCheckoutCartFooter()->getButtonHold()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(1);

        //Go to on-hold order page
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->onHoldOrders();
        sleep(1);

        //Enter incorrect customer name/order id into box search
        $this->webposIndex->getOnHoldOrderOrderList()->getSearchOrderInput()->setValue($idOrder1);
        sleep(1);

        //Enter or click on Search icon
        $this->webposIndex->getOnHoldOrderOrderList()->getIconSearch()->click();
        $this->webposIndex->getOnHoldOrderOrderList()->waitLoader();
        sleep(1);

    }
}