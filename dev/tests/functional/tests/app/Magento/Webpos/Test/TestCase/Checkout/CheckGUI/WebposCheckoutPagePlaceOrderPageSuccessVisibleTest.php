<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 05/12/2017
 * Time: 09:17
 */

namespace Magento\Webpos\Test\TestCase\Checkout\CheckGUI;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Mtf\Fixture\FixtureFactory;
/**
 * Class WebposCheckoutPagePlaceOrderPageSuccessVisibleTest
 * @package Magento\Webpos\Test\TestCase\Checkout\CheckGUI
 */
class WebposCheckoutPagePlaceOrderPageSuccessVisibleTest extends Injectable
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
    public function test(Staff $staff, $testCaseId, $labels, FixtureFactory $fixtureFactory, $products, $defaultValue)
    {
        $this->objectManager->create(
            '\Magento\Webpos\Test\TestStep\LoginWebposStep',
            ['staff' => $staff]
        )->run();
        if ($testCaseId == 'CP02') {
            $labels = explode(',', $labels);
            foreach ($labels as $label) {
                \PHPUnit_Framework_Assert::assertEquals(
                    $defaultValue,
                    str_replace('$', '', $this->webposIndex->getCheckoutCartFooter()->getGrandTotalItemPrice($label)->getText()),
                    'On the Frontend Page - The Default ' .$label. ' at the Webpos Cart was not equal to zero.'
                );
            }
        }
        $i = 0;
        foreach ($products as $product) {
            $products[$i] = $fixtureFactory->createByCode('catalogProductSimple', ['dataset' => $product]);
            $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
            $this->webposIndex->getCheckoutProductList()->search($products[$i]->getSku());
            $i++;
        }
        if ($testCaseId == 'CP03' || $testCaseId == 'CP04') {
            $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
            $this->webposIndex->getCheckoutPlaceOrder()->waitCartLoader();
            $this->webposIndex->getCheckoutPlaceOrder()->waitShippingSection();
            $this->webposIndex->getCheckoutPlaceOrder()->waitPaymentSection();
        }
        if ($testCaseId == 'CP04') {
            $this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
            $this->webposIndex->getCheckoutPlaceOrder()->waitCartLoader();
            $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
            $this->webposIndex->getCheckoutPlaceOrder()->waitCartLoader();
        }
    }
}
