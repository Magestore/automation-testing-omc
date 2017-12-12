<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 06/12/2017
 * Time: 10:36
 */

namespace Magento\Webpos\Test\Constraint\Checkout\CartPageActionMenu;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class AssertWebposExitFullScreen
 * @package Magento\Webpos\Test\Constraint\Checkout\CartPageActionMenu
 */
class AssertWebposExitFullScreen extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex)
    {
        for ($i=0; $i<2; $i++) {
            $webposIndex->getCheckoutCartHeader()->getIconActionMenu()->click();
            $webposIndex->getCheckoutFormAddNote()->waitFullScreenMode();
            $webposIndex->getCheckoutFormAddNote()->getFullScreenMode()->click();
        }
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "On the Checkout Page - Products List Page - All the action CLOSE ORDER NOTE And SAVE ORDER NOTE, TEXTAREA at the web POS Cart were visible successfully.";
    }
}