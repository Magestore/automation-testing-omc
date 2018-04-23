<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 1/25/2018
 * Time: 8:20 AM
 */

namespace Magento\Webpos\Test\TestCase\OrdersHistory\MassActionAddComment;

use Magento\Sales\Test\Fixture\OrderInjectable;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Mtf\TestCase\Injectable;


/**
 * Class WebposOrdersHistoryMassActionAddCommentTest
 * @package Magento\Webpos\Test\TestCase\OrdersHistory\MassActionSendMail
 */
class WebposOrdersHistoryMassActionAddCommentTest extends Injectable
{
    /**
     * @var WebposIndex
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
     * @param null $action
     * @param null $comment
     * @return array
     */
    public function test(
        OrderInjectable $order,
        $action = null,
        $comment = null
    )
    {
        // Preconditions
        $order->persist();

        // Login webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        // Step
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->ordersHistory();
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        sleep(0.5);
        $this->webposIndex->getOrderHistoryOrderViewHeader()->openAddOrderNote();
        sleep(0.5);
        $this->webposIndex->getOrderHistoryOrderViewHeader()->getAction('Add Comment')->click();

        if ($action === 'Save') {
            $this->webposIndex->getOrderHistoryAddComment()->getInputComment()->setValue($comment);
            $this->webposIndex->getOrderHistoryAddComment()->getSaveButton()->click();
            sleep(1);
        }elseif ($action === 'Cancel') {
            $this->webposIndex->getOrderHistoryAddComment()->getCancelButton()->click();
            sleep(1);
        }

        return [
            'action' => $action,
            'comment' => $comment
        ];
    }
}