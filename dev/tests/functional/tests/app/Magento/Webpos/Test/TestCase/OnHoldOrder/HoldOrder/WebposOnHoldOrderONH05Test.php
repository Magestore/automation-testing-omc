<?php
/**
 * Created by PhpStorm.
 * User: bang
 * Date: 26/01/2018
 * Time: 14:00
 */

namespace Magento\Webpos\Test\TestCase\OnHoldOrder\HoldOrder;

use Magento\Config\Test\Fixture\ConfigData;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposOnHoldOrderONH05Test
 * @package Magento\Webpos\Test\TestCase\OnHoldOrder\HoldOrder
 * Precondition and setup steps:
 * 1. Login webpos as a staff
 * 2. Add some  products to cart
 * 3. Click on [Hold] button
 * Steps:
 * 1. Click on On-Hold Orders menu
 * Acceptance Criteria:
 * "A new on-hold order is created including:
 * - On-hold order list: that on-hold order will be shown on the top of list with correct Grand total and Create time
 * - On-hold order detail:
 * + Onhold order ID, grand total, status, create date, served by
 * + Billing address, Shipping address: show guest information
 * + Items table: Show all  products that added to cart corressponding to their original, price, qty
 * + Fields: subtotal, shipping, grand total with their amount
 * + Buttons: Delete, checkout
 */
class WebposOnHoldOrderONH05Test extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * @param FixtureFactory $fixtureFactory
     */
    public function __prepare(FixtureFactory $fixtureFactory)
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
     * @param ConfigData $configData
     * @return array
     */
    public function test($products, ConfigData $configData)
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

        //Create a on-hold-order
        //Add some taxable products to cart
        $this->webposIndex->getCheckoutProductList()->search($product1->getName());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        sleep(1);
        $this->webposIndex->getCheckoutProductList()->search($product2->getName());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        sleep(1);
        //Hold
        $this->webposIndex->getCheckoutCartFooter()->getButtonHold()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(2);

        $configData = $configData->getData()['section'];
        $dataProduct1 = $product1->getData();
        $dataProduct1['qty'] = '1';
        $dataProduct2 = $product2->getData();
        $dataProduct2['qty'] = '1';
        return ['products' => [$dataProduct1, $dataProduct2],
            'product' => $dataProduct1,
            'name' => $configData['webpos/guest_checkout/first_name']['value'] . ' ' . $configData['webpos/guest_checkout/first_name']['value'],
            'address' => $configData['webpos/guest_checkout/city']['value'] . ', ' . $configData['webpos/guest_checkout/region_id']['label'] .
                ', ' . $configData['webpos/guest_checkout/zip']['value'] . ', US',
            'phone' => $configData['webpos/guest_checkout/telephone']['value']
        ];

    }
}