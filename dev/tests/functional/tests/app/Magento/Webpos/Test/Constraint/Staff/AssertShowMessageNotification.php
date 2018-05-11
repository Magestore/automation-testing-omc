<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 20/01/2018
 * Time: 12:22
 */
namespace Magento\Webpos\Test\Constraint\Staff;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertShowMessageNotification extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $message)
    {
        $messageActual = $webposIndex->getToaster()->getWarningMessage()->getText();
        \PHPUnit_Framework_Assert::assertEquals(
            $message,
            $messageActual,
            'Message is incorrect'
        );
        sleep(5);
    }
    public function toString()
    {
        return "Message is correct";
    }
}