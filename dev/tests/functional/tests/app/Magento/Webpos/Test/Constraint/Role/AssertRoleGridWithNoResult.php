<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/9/18
 * Time: 1:42 PM
 */

namespace Magento\Webpos\Test\Constraint\Role;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleIndex;

class AssertRoleGridWithNoResult extends AbstractConstraint
{

    public function processAssert(WebposRoleIndex $webposRoleIndex){
        \PHPUnit_Framework_Assert::assertFalse(
            $webposRoleIndex->getRoleGrid()->isFirstRowVisible(),
            'Grid has data'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Role grid has no result';
    }
}