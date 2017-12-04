<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 27/11/2017
 * Time: 10:47
 */
namespace Magento\BarcodeSuccess\Test\Constraint\Adminhtml\BarcodeListing;
use Magento\Backend\Test\Page\Adminhtml\Dashboard;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertGridPageActionButtonImportIsVisible extends AbstractConstraint
{
    public function processAssert(Dashboard $dashboard, $button='')
    {
        \PHPUnit_Framework_Assert::assertTrue(
                $dashboard->getActionImportBlock()->buttonIsVisible($button),
                'Button "'.$button.'" is not shown'
            );

    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Buttons Import is visible";
    }
}