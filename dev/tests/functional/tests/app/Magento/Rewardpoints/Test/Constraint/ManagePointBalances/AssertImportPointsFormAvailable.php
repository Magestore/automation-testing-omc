<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 11/28/2017
 * Time: 9:18 AM
 */

namespace Magento\Rewardpoints\Test\Constraint\Store;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Rewardpoints\Test\Page\Adminhtml\ManagePointBalancesImportPoints;

class AssertImportPointsFormAvailable extends AbstractConstraint
{

    public function processAssert(ManagePointBalancesImportPoints $importPoints)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $importPoints->getImportPoints()->isVisible(),
            'Import Points form is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $importPoints->getImportPoints()->importPointsTitleIsVisible(),
            'Import Points title is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $importPoints->getImportPoints()->importFileFieldIsVisible(),
            'Import Points file field is not visible.'
        );
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Import Points form is available.';
    }
}