<?php

/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 2/6/2018
 * Time: 8:59 AM
 */
namespace Magento\Webpos\Test\Constraint\OrderHistory\TakePayment;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;


class AssertWebposTakePaymentOH99 extends AbstractConstraint
{


    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Order History - Order Status was correctly.";
    }
}