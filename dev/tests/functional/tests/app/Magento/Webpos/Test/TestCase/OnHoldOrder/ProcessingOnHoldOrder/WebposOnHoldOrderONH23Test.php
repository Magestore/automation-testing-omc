<?php
/**
 * Created by PhpStorm.
 * User: bang
 * Date: 26/01/2018
 * Time: 13:26
 */

namespace Magento\Webpos\Test\TestCase\OnHoldOrder\ProcessingOnHoldOrder;

use Magento\Config\Test\Fixture\ConfigData;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposOnHoldOrderONH23Test
 * @package Magento\Webpos\Test\TestCase\OnHoldOrder\ProcessingOnHoldOrder
 * Precondition and setup steps:
 * 1. Login Webpos as a staff
 * 2. Create an on-hold order successfully
 * Steps:
 * 1. Go to On-hold order menu
 * 2. Click on [Checkout] button on that on-hold order
 * 3. Place order
 * Acceptance Criteria:
 * Place order successfully with information of the on-hold order
 */
class WebposOnHoldOrderONH23Test extends Injectable
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
     * @param ConfigData $configData
     * @return array
     */
    public function test($products, ConfigData $configData)
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

        //Create a on-hold-order
        //Add a product to cart
        $this->webposIndex->getCheckoutProductList()->search($product->getName());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        sleep(1);
        //Hold
        $this->webposIndex->getCheckoutCartFooter()->getButtonHold()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(1);

        //Cart in On-Hold
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->onHoldOrders();
        sleep(1);
        $this->webposIndex->getOnHoldOrderOrderList()->getFirstOrder()->click();
        $this->webposIndex->getOnHoldOrderOrderViewFooter()->getCheckOutButton()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(1);

        //PlaceOrder
        $this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
        sleep(1);
        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $this->webposIndex->getCheckoutPlaceOrder()->waitCartLoader();
        sleep(1);

        //Get orderId
        $orderId = $this->webposIndex->getCheckoutSuccess()->getOrderId()->getText();
        $orderId = ltrim($orderId, '#');
        $this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
        $dataProduct = $product->getData();
        $dataProduct['qty'] = '1';
        $configData = $configData->getData()['section'];
        return [
            'name' => $configData['webpos/guest_checkout/first_name']['value'] . ' ' . $configData['webpos/guest_checkout/last_name']['value'],
            'address' => $configData['webpos/guest_checkout/city']['value'] . ', ' . $configData['webpos/guest_checkout/region_id']['label'] .
                ', ' . $configData['webpos/guest_checkout/zip']['value'] . ', US',
            'phone' => $configData['webpos/guest_checkout/telephone']['value'],
            'orderId' => $orderId,
            'products' => [$dataProduct]
        ];
    }
}