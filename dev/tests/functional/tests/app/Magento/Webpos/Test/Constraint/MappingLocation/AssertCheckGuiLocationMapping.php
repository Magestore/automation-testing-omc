<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/10/18
 * Time: 9:57 AM
 */

namespace Magento\Webpos\Test\Constraint\MappingLocation;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\MappingLocationIndex;

class AssertCheckGuiLocationMapping extends AbstractConstraint
{

    public function processAssert(MappingLocationIndex $mappingLocationIndex, $buttons, $fields)
    {
        $buttons = explode(',', $buttons);
        foreach ($buttons as $button) {
            $button = trim($button);
            $this->assertButton($mappingLocationIndex, $button);
        }
    }

    private function assertButton(MappingLocationIndex $mappingLocationIndex, $button)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $mappingLocationIndex->getFormPageActions()->getButtonByName($button)->isVisible(),
            'Button ' . $button . ' could not show'
        );
    }

    private function assertFilter(MappingLocationIndex $mappingLocationIndex, $field)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $mappingLocationIndex->getMappingLocationGrid()->getFieldByName($field)->isVisible(),
            'Field ' . $field . ' could not show'
        );
    }


    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Mapping Location Page could show correct";
    }
}