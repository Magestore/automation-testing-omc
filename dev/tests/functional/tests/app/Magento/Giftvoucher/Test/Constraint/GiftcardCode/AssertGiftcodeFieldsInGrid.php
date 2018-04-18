<?php

namespace Magento\Giftvoucher\Test\Constraint\GiftcardCode;

use Magento\Giftvoucher\Test\Page\Adminhtml\GiftcodeIndex;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Giftvoucher\Test\Fixture\Giftcode;

class AssertGiftcodeFieldsInGrid extends AbstractConstraint
{
    /**
     * Assert after update gift code
     *
     * @param GiftcodeIndex $giftcodeIndex
     * @param array $giftcode
     * @param array $fields
     */
    public function processAssert(GiftcodeIndex $giftcodeIndex, Giftcode $update, array $giftcode, array $fields)
    {
        $grid = $giftcodeIndex->getGiftcodeGroupGrid();
        $grid->resetFilter(); // Reset Filter
        foreach ($fields as $key => $field) {
            \PHPUnit_Framework_Assert::assertEquals(
                empty($field['value']) ? $update->getData($key) : $field['value'],
                $grid->getColumnValue($giftcode['giftvoucher_id'], $field['label']),
                'Field ' . $field['label'] . ' is not updated'
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
        return 'Gift code grid field display match target';
    }
}
