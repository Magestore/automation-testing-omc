<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 31/01/2018
 * Time: 08:19
 */
namespace Magento\Webpos\Test\Constraint\OnHoldOrder\CheckGUI;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertCheckVisibleGUI extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $searchPlaceHolder, $product)
    {
        $webposIndex->getMsWebpos()->clickCMenuButton();
        $webposIndex->getCMenu()->onHoldOrders();
        sleep(1);
        $webposIndex->getOnHoldOrderOrderList()->waitLoader();

        //Check visible on-hold-order list
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getOnHoldOrderOrderList()->isVisible(),
            'List On-Hold-Order is not display'
        );

        //Check visible on-hold-order content
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getOnHoldOrderOrderViewContent()->isVisible(),
            'Content is not display'
        );

        //Check visible Show menu icon, notification icon
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getMsWebpos()->getCMenuButton()->isVisible(),
            'Menu icon is not display'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getNotification()->getNotificationBell()->isVisible(),
            'Notification bell is not display'
        );

        //Check visible Text search and place holder
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getOnHoldOrderOrderList()->getSearchOrderInput()->isVisible(),
            'Text search is not display'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $searchPlaceHolder,
            $webposIndex->getOnHoldOrderOrderList()->getSearchOrderInput()->getAttribute('placeholder'),
            'Place holder is not fit'
        );

        //Check visible button checkout and delete
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getOnHoldOrderOrderViewFooter()->getCheckOutButton()->isVisible(),
            'Checkout button is not display'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getOnHoldOrderOrderViewFooter()->getDeleteButton()->isVisible(),
            'Delete button is not display'
        );

        //Check order detail contain : Information about ID, customer, shipping, billing, items and total
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getOnHoldOrderOrderViewHeader()->getBlockIdOrder()->isVisible(),
            'Order id is not display'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getOnHoldOrderOrderViewContent()->getShipping()->isVisible(),
            'Shipping is not display'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getOnHoldOrderOrderViewContent()->getBilling()->isVisible(),
            'Billing is not display'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getOnHoldOrderOrderViewContent()->getProductRow($product['name'])->isVisible(),
            'Item product is not display'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getOnHoldOrderOrderViewFooter()->getTableTotal()->isVisible(),
            'Total table is not display'
        );

        //Check create at, serve by, status
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getOnHoldOrderOrderViewHeader()->getCreateAt()->isVisible(),
            'Create at is not display'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getOnHoldOrderOrderViewHeader()->getServeBy()->isVisible(),
            'Serve by is not display'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getOnHoldOrderOrderViewHeader()->getStatus()->isVisible(),
            'Status is not display'
        );

        //Check fields: subtotal, shipping, grand total
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getOnHoldOrderOrderViewFooter()->getRow('Subtotal')->isVisible(),
            'Subtotal table is not display'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getOnHoldOrderOrderViewFooter()->getRow('Shipping')->isVisible(),
            'Shipping table is not display'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getOnHoldOrderOrderViewFooter()->getRow('Grand Total')->isVisible(),
            'Grand total table is not display'
        );

        //Check title time
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getOnHoldOrderOrderList()->getFirstTitleTime()->isVisible(),
            'Title time is not display'
        );

        $webposIndex->getMsWebpos()->clickCMenuButton();
        $webposIndex->getCMenu()->checkout();
        sleep(1);
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "GUI is display full";
    }
}