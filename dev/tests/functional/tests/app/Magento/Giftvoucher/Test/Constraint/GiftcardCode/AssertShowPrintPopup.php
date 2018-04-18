<?php

namespace Magento\Giftvoucher\Test\Constraint\GiftcardCode;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Mtf\Client\DriverInterface;
use Magento\Giftvoucher\Test\Page\Adminhtml\GiftcodePrint;

class AssertShowPrintPopup extends AbstractConstraint
{
    public function processAssert(DriverInterface $driver, GiftcodePrint $giftcodePrint)
    {
        $driver->selectWindow('newWindow');
        \PHPUnit_Framework_Assert::assertTrue(
            $giftcodePrint->getPrintBlock()->isVisible(),
            'Print popup is not showed.'
        );
        $driver->closeWindow('newWindow');
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Print popup is displayed.';
    }
}
