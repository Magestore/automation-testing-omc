<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 11/01/2018
 * Time: 15:56
 */
namespace Magento\Webpos\Test\Constraint\Checkout\CartPageActionMenu;

use Magento\Mtf\Constraint\AbstractConstraint;
/**
 * Class AssertWebposEnterFullScreenAgain
 * @package Magento\Webpos\Test\Constraint\Cart\CartPageActionMenu
 */
class AssertWebposEnterFullScreenAgain extends AbstractConstraint
{
    public function processAssert($minHeightBeforeFull, $minHeightAfterFull, $minHeightAfterAgain)
    {
        if(($minHeightAfterFull > $minHeightBeforeFull) && ($minHeightBeforeFull == $minHeightAfterAgain))
            $tag = 'OK';
        else
            $tag = 'None';
        \PHPUnit_Framework_Assert::assertEquals('OK',$tag,
            'Khong thanh cong');
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "On the CategoryRepository Page - Products List Page - All the action CLOSE ORDER NOTE And SAVE ORDER NOTE, TEXTAREA at the web POS TaxClass were visible successfully.";
    }
}