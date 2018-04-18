<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 25/01/2018
 * Time: 15:44
 */
namespace Magento\Webpos\Test\Constraint\OnHoldOrder\Search;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertCheckSearch extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $result, $input)
    {
        if($result == 'empty')
        {
            \PHPUnit_Framework_Assert::assertFalse(
                $webposIndex->getOnHoldOrderOrderList()->getFirstOrder()->isPresent(),
                'List Order is not empty'
            );

            \PHPUnit_Framework_Assert::assertTrue(
                $webposIndex->getOnHoldOrderOrderViewContent()->isMessageEmptyDiplay(),
                'Content is not empty'
            );
        } else if ($result == 'customer')
        {
            $equa = strpos(strtolower($webposIndex->getOnHoldOrderOrderList()->getFullNameCustomer()->getText()), strtolower($input));
            if($equa !== false)
            {
                \PHPUnit_Framework_Assert::assertTrue(
                    true,
                    'List Order is not show order contain customer'
                );
            }else
                \PHPUnit_Framework_Assert::assertTrue(
                    false,
                    'List Order is not show order contain customer'
                );

            \PHPUnit_Framework_Assert::assertFalse(
                $webposIndex->getOnHoldOrderOrderViewContent()->isMessageEmptyDiplay(),
                'Content is empty'
            );
        } else if ($result == 'idOrder')
        {
            $actual = $webposIndex->getOnHoldOrderOrderList()->getIdFirstOrder();
            \PHPUnit_Framework_Assert::assertEquals(
                $input,
                $actual,
                'Order is incorrect'
            );

            \PHPUnit_Framework_Assert::assertFalse(
                $webposIndex->getOnHoldOrderOrderViewContent()->isMessageEmptyDiplay(),
                'Content is empty'
            );
        }
    }



    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "On-hold-order is correct";
    }
}