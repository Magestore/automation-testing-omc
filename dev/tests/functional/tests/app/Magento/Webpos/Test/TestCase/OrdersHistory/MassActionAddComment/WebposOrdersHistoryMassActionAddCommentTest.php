<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 1/25/2018
 * Time: 8:20 AM
 */

namespace Magento\Webpos\Test\TestCase\OrdersHistory\MassActionAddComment;

use Magento\Mtf\TestCase\Injectable;
use Magento\Sales\Test\Fixture\OrderInjectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposOrdersHistoryMassActionAddCommentTest
 * @package Magento\Webpos\Test\TestCase\OrdersHistory\MassActionSendMail
 * OH24:
 * Precondition and setup steps:
 * 1. Login webpos as a staff
 * 2. Create an order successfully
 * Steps:
 * 1. Go to order details page
 * 2. Click on icon on the top of the right
 * 3. Click on Add comment action
 * Acceptance Criteria:
 * Display Add Comment popup includding:
 * - button: Cancel, Save
 * - Textarea to enter comment
 *
 * OH25:
 * Precondition and setup steps:
 * 1. Login webpos as a staff
 * 2. Create an order successfully
 * Steps:
 * 1. Click to Add comment
 * 2. Click on Cancel button
 * Acceptance Criteria:
 * Close Add comment popup
 *
 * OH26:
 * Precondition and setup steps:
 * 1. Login webpos as a staff
 * 2. Create an order successfully
 * Steps:
 * 1. Click to Add comment
 * 2. Click on Save button
 * Acceptance Criteria:
 * 1. Close Add comment popup
 * 2. Comment will be added and display on order detail page
 * 3. A new notification will be display on notification icon
 */
class WebposOrdersHistoryMassActionAddCommentTest extends Injectable
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
        sleep(1);
        $this->webposIndex->getOrderHistoryOrderViewHeader()->getAction('Add Comment')->click();

        if ($action === 'Save') {
            $this->webposIndex->getOrderHistoryAddComment()->getInputComment()->setValue($comment);
            sleep(0.5);
            $this->webposIndex->getOrderHistoryAddComment()->getSaveButton()->click();
            sleep(1);
        } elseif ($action === 'Cancel') {
            sleep(0.5);
            $this->webposIndex->getOrderHistoryAddComment()->getCancelButton()->click();
            sleep(1);
        }

        return [
            'action' => $action,
            'comment' => $comment
        ];
    }
}