<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/9/18
 * Time: 2:02 PM
 */

namespace Magento\Webpos\Test\Constraint\Role;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleIndex;

class AssertSearchGridWithResult extends AbstractConstraint
{

    public function processAssert(WebposRoleIndex $webposRoleIndex, $webposRole, $fullCondition = false){
        $filter = [
            'display_name' => $webposRole->getDisplayName()
        ];
       if($fullCondition){
           $filter['id'] =  $webposRole->getRoleId();
           $filter['description'] = $webposRole->getDescription();
       }
        \PHPUnit_Framework_Assert::assertTrue(
            $webposRoleIndex->getRoleGrid()->isRowVisible($filter),
            'Grid has no data'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Role Gid has result';
    }
}