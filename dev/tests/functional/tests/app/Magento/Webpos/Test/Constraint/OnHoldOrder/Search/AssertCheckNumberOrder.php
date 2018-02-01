<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 01/02/2018
 * Time: 09:32
 */
namespace Magento\Webpos\Test\Constraint\OnHoldOrder\Search;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertCheckNumberOrder extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $numberExpected)
    {
        $numberActual = 0;
        for($i=0; $i<$numberExpected; ++$i)
        {
            if($webposIndex->getOnHoldOrderOrderList()->getOrderByStt($i+1)->isVisible())
                $numberActual++;
        }
        \PHPUnit_Framework_Assert::assertEquals(
            $numberExpected,
            $numberActual,
            'Number ordre is empty'
        );
    }



    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Number order is correct";
    }
}