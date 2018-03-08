<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 20/01/2018
 * Time: 12:22
 */
namespace Magento\Webpos\Test\Constraint\Adminhtml\Staff\Permission;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertWarningDiscountCustomPrice extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $messageWarning)
    {
        $messageActual = $webposIndex->getToaster()->getWarningMessage()->getText();

        \PHPUnit_Framework_Assert::assertEquals(
            $messageWarning,
            $messageActual,
            'Message warning is incorrect'
        );

    }



    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Message warning is correct";
    }
}