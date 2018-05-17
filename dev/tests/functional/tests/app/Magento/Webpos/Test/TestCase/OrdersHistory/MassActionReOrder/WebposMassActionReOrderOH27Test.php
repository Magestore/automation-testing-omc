<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 1/25/2018
 * Time: 10:33 AM
 */

namespace Magento\Webpos\Test\TestCase\OrdersHistory\MassActionReOrder;

use Magento\Sales\Test\Fixture\OrderInjectable;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Mtf\TestCase\Injectable;

class WebposMassActionReOrderOH27Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    public function __inject(WebposIndex $webposIndex)
    {
        $this->webposIndex = $webposIndex;
    }

    public function test(
        OrderInjectable $order
    )
    {
        // Preconditions
        $order->persist();
        $list = $order->getEntityId()['products'];
        $products = [];
        foreach ($list as $key => $value){
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
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        $this->webposIndex->getMsWebpos()->waitOrdersHistoryVisible();

        $this->webposIndex->getOrderHistoryOrderViewHeader()->openAddOrderNote();
        $this->webposIndex->getOrderHistoryOrderViewHeader()->getAction('Re-order')->click();

        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();

        return [
            'products' => $products
        ];
    }
}