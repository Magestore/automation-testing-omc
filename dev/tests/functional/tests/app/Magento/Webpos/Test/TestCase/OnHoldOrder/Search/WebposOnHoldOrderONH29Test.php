<?php
/**
 * Created by PhpStorm.
 * User: bang
 * Date: 26/01/2018
 * Time: 13:26
 */

namespace Magento\Webpos\Test\TestCase\OnHoldOrder\Search;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\OnHoldOrder\Search\AssertCheckSearch;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposOnHoldOrderONH29Test
 * @package Magento\Webpos\Test\TestCase\OnHoldOrder\Search
 * Precondition and setup steps:
 * 1. Login Webpos as a staff
 * 2. Create an on-hold order successfully
 * Steps:
 * 1. Go to on-hold order page
 * 2. Enter correct customer name/ order ID into box search
 * 3. Click on Search icon
 * 4. Remove keyword
 * Acceptance Criteria:
 * Back to default list, all on-hold orders will be shown on list
 */
class WebposOnHoldOrderONH29Test extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;
    /**
     * @var AssertCheckSearch $assertCheckSearch
     */
    protected $assertCheckSearch;

    /**
     * @param WebposIndex $webposIndex
     * @param AssertCheckSearch $assertCheckSearch
     */
    public function __inject
    (
        WebposIndex $webposIndex,
        AssertCheckSearch $assertCheckSearch
    )
    {
        $this->webposIndex = $webposIndex;
        $this->assertCheckSearch = $assertCheckSearch;
    }

    /**
     * @param $products
     * @return array
     */
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

        //LoginTest webpos
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

        //Get idOrder1
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->onHoldOrders();
        sleep(1);
        $idOrder1 = $this->webposIndex->getOnHoldOrderOrderList()->getIdFirstOrder();
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->checkout();
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

        //Enter correct customer name/order id into box search
        $this->webposIndex->getOnHoldOrderOrderList()->getSearchOrderInput()->setValue($idOrder1);
        sleep(1);

        //Enter or click on Search icon
        $this->webposIndex->getOnHoldOrderOrderList()->getIconSearch()->click();
        $this->webposIndex->getOnHoldOrderOrderList()->waitLoader();
        sleep(1);
        $this->assertCheckSearch->processAssert($this->webposIndex, 'idOrder', $idOrder1);

        //Remove keyword
        $this->webposIndex->getOnHoldOrderOrderList()->getSearchOrderInput()->setValue('');
        sleep(1);

        //Enter or click on Search icon
        $this->webposIndex->getOnHoldOrderOrderList()->getIconSearch()->click();
        $this->webposIndex->getOnHoldOrderOrderList()->waitLoader();
        sleep(1);

        return ['numberExpected' => 3];
    }
}