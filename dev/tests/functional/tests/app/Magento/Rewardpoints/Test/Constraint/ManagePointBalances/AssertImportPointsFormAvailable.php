<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 11/28/2017
 * Time: 9:18 AM
 */

namespace Magento\Rewardpoints\Test\Constraint\ManagePointBalances;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Rewardpoints\Test\Page\Adminhtml\ManagePointBalancesImportPoints;

/**
 * Class AssertImportPointsFormAvailable
 * @package Magento\Rewardpoints\Test\Constraint\ManagePointBalances
 */
class AssertImportPointsFormAvailable extends AbstractConstraint
{

    /**
     * @param ManagePointBalancesImportPoints $importPoints
     */
    public function processAssert(ManagePointBalancesImportPoints $importPoints)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $importPoints->getImportPointsForm()->isVisible(),
            'Import Points form is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $importPoints->getImportPointsForm()->importPointsTitleIsVisible(),
            'Import Points title is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $importPoints->getImportPointsForm()->importFileFieldIsVisible(),
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