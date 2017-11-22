<?php

namespace Magento\Giftvoucher\Test\Constraint\GiftcardCode;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Mtf\Client\DriverInterface;
use Magento\Giftvoucher\Test\Page\Adminhtml\GiftcodePrint;

class AssertShowPrintTab extends AbstractConstraint
{
    public function processAssert(DriverInterface $driver, GiftcodePrint $giftcodePrint)
    {
        $driver->selectWindow();
        \PHPUnit_Framework_Assert::assertTrue(
            $giftcodePrint->getPrintBlock()->isVisible(),
            'Print popup is not showed.'
        );
        $driver->closeWindow();
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Print tab is displayed.';
    }
}
