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

/**
 * Class WebposOnHoldOrderONH15Test
 * @package Magento\Webpos\Test\TestCase\OnHoldOrder\HoldOrder
 * Precondition and setup steps:
 * 1. Login Webpos as a staff
 * 2. Click to add multi order
 * 3. Add some product to 1st cart and 2nd cart
 * Steps:
 * 1. Click on [Hold] button
 * Acceptance Criteria:
 * 1. Hold order successfully
 * 2. 1st cart back to default, 2nd cart is changeless
 */
class WebposOnHoldOrderONH15Test extends Injectable
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

        //LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        //Create multiorder
        $this->webposIndex->getCheckoutCartHeader()->getAddMultiOrder()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        sleep(2);
        $this->webposIndex->getCheckoutCartHeader()->getMultiOrderItem('1')->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(2);
        //Add a taxable products to cart
        $this->webposIndex->getCheckoutProductList()->search($product1->getName());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        $this->webposIndex->getCheckoutCartHeader()->getMultiOrderItem('2')->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(2);
        //Add a taxable products to cart
        $this->webposIndex->getCheckoutProductList()->search($product2->getName());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getCheckoutCartHeader()->getMultiOrderItem('1')->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        sleep(2);
        for ($i=0; $i<5; $i++) {
            while ($this->webposIndex->getMsWebpos()->getCartLoader()->isVisible()) {
                $this->webposIndex->getMsWebpos()->waitCartLoader();
            }
        }

        //Hold
        $this->webposIndex->getCheckoutCartFooter()->getButtonHold()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(1);

        $dataProduct1 = $product1->getData();
        $dataProduct1['qty'] = '1';
        $dataProduct2 = $product2->getData();
        $dataProduct2['qty'] = '1';
        return ['products' => [$dataProduct1],
            'cartProducts' => null
        ];

    }
}