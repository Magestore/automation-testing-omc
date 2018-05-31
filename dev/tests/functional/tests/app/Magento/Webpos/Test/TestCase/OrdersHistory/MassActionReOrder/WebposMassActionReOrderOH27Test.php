<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 1/25/2018
 * Time: 10:33 AM
 */

namespace Magento\Webpos\Test\TestCase\OrdersHistory\MassActionReOrder;

use Magento\Mtf\TestCase\Injectable;
use Magento\Sales\Test\Fixture\OrderInjectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposMassActionReOrderOH27Test
 * @package Magento\Webpos\Test\TestCase\OrdersHistory\MassActionReOrder
 * Precondition and setup steps:
 * 1. Login webpos as a staff
 * 2. Add some products
 * 3. Create order successfully
 * Steps:
 * 1. Go to order details page
 * 2. Click on icon on the top of the right
 * 3. Click on Re-order action
 * Acceptance Criteria:
 * 1. Redirect to checkout page
 * 2. All items in the current order will be loaded to cart
 */
class WebposMassActionReOrderOH27Test extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * @param WebposIndex $webposIndex
     */
    public function __inject(WebposIndex $webposIndex)
    {
        $this->webposIndex = $webposIndex;
    }

    /**
     * @param OrderInjectable $order
     * @return array
     */
    public function test(
        OrderInjectable $order
    )
    {
        // Preconditions
        $order->persist();
        $list = $order->getEntityId()['products'];
        $products = [];
        foreach ($list as $key => $value) {
            $products[$key]['product'] = $value;
        }

        // LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        // Step
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->ordersHistory();
        $this->webposIndex->getMsWebpos()->waitOrdersHistoryVisible();
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        $this->webposIndex->getOrderHistoryOrderList()->waitOrderListIsVisible();

        $this->webposIndex->getOrderHistoryOrderViewHeader()->openAddOrderNote();
        $this->webposIndex->getOrderHistoryOrderViewHeader()->getAction('Re-order')->click();

        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();

        return [
            'products' => $products
        ];
    }
}