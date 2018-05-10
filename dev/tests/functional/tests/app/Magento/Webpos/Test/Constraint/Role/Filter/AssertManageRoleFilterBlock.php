<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/9/18
 * Time: 10:25 AM
 */
namespace Magento\Webpos\Test\Constraint\Role\Filter;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleIndex;

class AssertManageRoleFilterBlock extends AbstractConstraint

{
    public function processAssert(WebposRoleIndex $webposRoleIndex, $fields){
        $fields = explode(',', $fields);
       foreach ($fields as $field){
           $field = trim($field);
            \PHPUnit_Framework_Assert::assertTrue(
                $webposRoleIndex->getRoleGrid()->getFilterFieldByName($field)->isPresent(),
                'Field '.$field.' could n\'t show'
            );
       }
       sleep(1);
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Manage Role Filter BLock could show correct';
    }

}