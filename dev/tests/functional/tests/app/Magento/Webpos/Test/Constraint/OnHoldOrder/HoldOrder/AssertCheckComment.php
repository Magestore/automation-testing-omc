<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 01/02/2018
 * Time: 14:49
 */
namespace Magento\Webpos\Test\Constraint\OnHoldOrder\HoldOrder;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertCheckComment extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $comment)
    {
        $webposIndex->getMsWebpos()->clickCMenuButton();
        $webposIndex->getCMenu()->onHoldOrders();
        sleep(1);

        //Check comment
        $commentActual = $webposIndex->getOnHoldOrderOrderViewContent()->getComment()->getText();
        \PHPUnit_Framework_Assert::assertEquals(
            $comment,
            $commentActual,
            'Comment is not correct'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Comment is correct";
    }
}