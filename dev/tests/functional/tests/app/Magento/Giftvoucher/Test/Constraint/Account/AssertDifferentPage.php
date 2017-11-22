<?php
namespace Magento\Giftvoucher\Test\Constraint\Account;

use Magento\Mtf\Constraint\AbstractConstraint;

class AssertDifferentPage extends AbstractConstraint
{
    /**
     * @param array $result
     */
    public function processAssert($result = [])
    {
        $prev = null;
        foreach ($result as $id) {
            if (!is_null($prev)) {
                \PHPUnit_Framework_Assert::assertNotEquals(
                    $prev,
                    $id,
                    'Similar gift code on different page'
                );
            }
            $prev = $id;
        }
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Gift code paging.';
    }
}
