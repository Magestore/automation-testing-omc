<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 18/01/2018
 * Time: 13:35
 */
namespace Magento\Webpos\Test\TestCase\Checkout\CartPage\HoldOrder;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\ConfigurableProduct\Test\Fixture\ConfigurableProduct;

/**
 * Class WebposHoldOrderCP157Test
 *
 * Precondition:
 * 1. LoginTest Webpos as a staff
 * 2. Add a configurable product to cart
 * 3. Hold order successfully
 *
 * Steps:
 * 1. Go to [On-hold orders] menu
 * 2. Click on [Cart] button on that detail order"
 *
 * Acceptance: Order will be loaded to cart page with corresponding product and attributes
 *
 * @package Magento\Webpos\Test\TestCase\Cart\CartPage\HoldOrder
 */
class WebposHoldOrderCP157Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    public function __prepare(FixtureFactory $fixtureFactory)
    {
        //Create configProduct
        $product = $fixtureFactory->createByCode('configurableProduct', ['dataset' => 'with_one_attribute']);
        $product->persist();
        return ['product' => $product];
    }

    public function __inject
    (
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
    }

    public function test(ConfigurableProduct $product, $attribute)
    {
        //LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        //Add products to cart
        $this->webposIndex->getCheckoutProductList()->search($product->getName());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        sleep(1);
        $this->webposIndex->getCheckoutProductDetail()->selectedOneAttribute($attribute);
        sleep(1);
        $this->webposIndex->getCheckoutProductDetail()->getButtonAddToCart()->click();
        sleep(1);

        //Hold
        $this->webposIndex->getCheckoutCartFooter()->getButtonHold()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(1);

        //Cart in On-Hold
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->onHoldOrders();
        $this->webposIndex->getOnHoldOrderOrderList()->waitLoader();
        sleep(1);
        $this->webposIndex->getOnHoldOrderOrderList()->getFirstOrder()->click();
        $this->webposIndex->getOnHoldOrderOrderViewFooter()->getCheckOutButton()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(1);

        $dataProduct = $product->getData();
        $dataProduct['qty'] = 1;
        return ['cartProducts' => [$dataProduct]];
    }
}