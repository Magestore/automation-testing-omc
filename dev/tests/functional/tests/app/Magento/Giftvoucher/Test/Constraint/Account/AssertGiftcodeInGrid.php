<?php
namespace Magento\Giftvoucher\Test\Constraint\Account;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Giftvoucher\Test\Page\GiftvoucherIndexIndex;

class AssertGiftcodeInGrid extends AbstractConstraint
{
    public function processAssert(GiftvoucherIndexIndex $giftvoucherIndexIndex, $code)
    {
        $grid = $giftvoucherIndexIndex->getAccountGiftcodesBlock()->search($code);
        $body = $grid->find('tbody');
        
        \PHPUnit_Framework_Assert::assertEquals(
            1,
            count($body->getElements('tr'))
        );
        \PHPUnit_Framework_Assert::assertGreaterThan(
            1,
            count($body->getElements('td')),
            'Gift code "' . $code . '" is absent in list'
        );
    }
    
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Gift code is in grid.';
    }
}
