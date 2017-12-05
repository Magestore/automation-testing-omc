<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 04/12/2017
 * Time: 16:31
 */

namespace Magento\Webpos\Test\TestCase\Checkout\CheckGUI;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Mtf\Fixture\FixtureFactory;
/**
 * Class WebposCheckoutPageVisibleTest
 * @package Magento\Webpos\Test\TestCase\Checkout\CheckGUI
 */
class WebposCheckoutPageVisibleTest extends Injectable
{
    /**
     * Webpos Index page.
     *
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * @param WebposIndex $webposIndex
     * @return void
     */
    public function __inject(
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
    }

    /**
     * Login Webpos group test.
     *
     * @param Staff $staff
     * @param FixtureFactory $fixtureFactory
     * @return void
     */
    public function test(Staff $staff, FixtureFactory $fixtureFactory, $products, $labels, $defaultValue)
    {
        $this->webposIndex->open();
        if ($this->webposIndex->getLoginForm()->isVisible()) {
            $this->webposIndex->getLoginForm()->fill($staff);
            $this->webposIndex->getLoginForm()->clickLoginButton();
            sleep(5);
            while ($this->webposIndex->getFirstScreen()->isVisible()) {
            }
            sleep(2);
        }
        $labels = explode(',', $labels);
        foreach ($labels as $label) {
            self::assertEquals(
                $defaultValue,
                str_replace('$', '', $this->webposIndex->getCheckoutCartFooter()->getGrandTotalItemPrice($label)->getText()),
                'On the Frontend Page - The Default ' .$label. ' at the Webpos Cart was not equal to zero.'
            );
        }
        $i = 0;
        foreach ($products as $product) {
            $products[$i] = $fixtureFactory->createByCode('catalogProductSimple', ['dataset' => $product]);
            $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
            $this->webposIndex->getCheckoutProductList()->search($products[$i]->getSku());
            $i++;
        }
        self::assertTrue(
            $this->webposIndex->getCheckoutCartItems()->getProductImage()->isVisible(),
            'On the Frontend Page - The PRODUCT THUMBNAIL IMAGE at the web POS Cart was not visible.'
        );
        self::assertTrue(
            $this->webposIndex->getCheckoutCartItems()->getProductPrice()->isVisible(),
            'On the Frontend Page - The PRODUCT PRICE at the web POS Cart was not visible.'
        );
        self::assertTrue(
            $this->webposIndex->getCheckoutCartItems()->getIconDeleteItem()->isVisible(),
            'On the Frontend Page - The icon DELETE CART ITEM at the web POS Cart was not visible.'
        );
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getCheckoutPlaceOrder()->waitCartLoader();
        $this->webposIndex->getCheckoutPlaceOrder()->waitShippingSection();
        $this->webposIndex->getCheckoutPlaceOrder()->waitPaymentSection();
    }
}
