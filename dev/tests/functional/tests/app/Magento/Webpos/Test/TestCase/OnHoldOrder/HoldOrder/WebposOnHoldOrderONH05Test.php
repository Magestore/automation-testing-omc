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
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Config\Test\Fixture\ConfigData;

class WebposOnHoldOrderONH05Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    public function __prepare(FixtureFactory $fixtureFactory)
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'webpos_default_guest_checkout_rollback']
        )->run();
    }

    public function __inject
    (
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
    }

    public function test($products, ConfigData $configData)
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
        sleep(1);

        $configData = $configData->getData()['section'];
        $dataProduct1 = $product1->getData();
        $dataProduct1['qty'] = '1';
        $dataProduct2 = $product2->getData();
        $dataProduct2['qty'] = '1';
        return ['products' => [$dataProduct1, $dataProduct2],
            'product' => $dataProduct1,
            'name' => $configData['webpos/guest_checkout/first_name']['value'].' '.$configData['webpos/guest_checkout/first_name']['value'],
            'address' => $configData['webpos/guest_checkout/city']['value'].', '.$configData['webpos/guest_checkout/region_id']['label'].
                ', '.$configData['webpos/guest_checkout/zip']['value'].', US',
            'phone' =>  $configData['webpos/guest_checkout/telephone']['value']];

    }
}