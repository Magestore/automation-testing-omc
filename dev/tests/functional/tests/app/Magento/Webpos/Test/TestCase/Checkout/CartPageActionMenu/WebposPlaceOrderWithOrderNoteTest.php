<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 06/12/2017
 * Time: 08:14
 */

namespace Magento\Webpos\Test\TestCase\Checkout\CartPageActionMenu;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposPlaceOrderWithOrderNoteTest
 * @package Magento\AssertWebposCheckGUICustomerPriceCP54\Test\TestCase\CategoryRepository\CartPageActionMenu
 *
 * Precondition:
 * "1. Login Webpos as a staff
 * 2. Add a product to cart"
 *
 * Steps:
 * "1. Click on action menu ""..."" on the top-right of the screen
 * 2. Click on ""Add order note""
 * 3. Enter comment
 * 4. Click on ""Save"" button
 * 5. Place order "
 *
 * Acceptance:
 * "On detail order on webpos:
 * - Show content of comment in ""Comment history"" section
 * On detail order in backend:
 * - Show content of comment in ""Notes for this Order"" section"
 *
 */
class WebposPlaceOrderWithOrderNoteTest extends Injectable
{
    /**
     * AssertWebposCheckGUICustomerPriceCP54 Index page.
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
     * LoginTest AssertWebposCheckGUICustomerPriceCP54 group test.
     *
     * @param FixtureFactory $fixtureFactory
     * @return void
     */
    public function test(FixtureFactory $fixtureFactory, $products, $textNote)
    {
        $staff = $this->objectManager->create(
            '\Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $i = 0;
        foreach ($products as $product) {
            $products[$i] = $fixtureFactory->createByCode('catalogProductSimple', ['dataset' => $product]);
            $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
            $this->webposIndex->getCheckoutProductList()->search($products[$i]->getSku());
            $i++;
        }
        $this->webposIndex->getCheckoutCartHeader()->getIconActionMenu()->click();
        $this->webposIndex->getCheckoutFormAddNote()->getAddOrderNote()->click();

        sleep(2);
        $this->webposIndex->getCheckoutNoteOrder()->getTextArea()->setValue($textNote);
        $this->webposIndex->getCheckoutNoteOrder()->getSaveOrderNoteButon()->click();
        $this->webposIndex->getCheckoutPlaceOrder()->waitCartLoader();
        sleep(3);
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getCheckoutPlaceOrder()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(3);
        $this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
        $this->webposIndex->getCheckoutPlaceOrder()->waitCartLoader();
        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $this->webposIndex->getCheckoutPlaceOrder()->waitCartLoader();
        $result = [];
        $result['orderId'] = str_replace('#', '', $this->webposIndex->getCheckoutSuccess()->getOrderId()->getText());
        $this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->ordersHistory();
        sleep(1);
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        $this->webposIndex->getOrderHistoryContainer()->getSearchOrderInput()->setValue($result['orderId']);
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        self::assertEquals(
            $textNote,
            $this->webposIndex->getOrderHistoryContainer()->getOrderNote()->getText(),
            'Order Note is wrong'
        );
    }
}