<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/28/2018
 * Time: 3:56 PM
 */

namespace Magento\Webpos\Test\Constraint\Role\EditRole;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleNew;

/**
 * Class AssertRoleFormPageActionAvailable
 * @package Magento\Webpos\Test\Constraint\Role\EditRole
 */
class AssertRoleFormPageActionAvailable extends AbstractConstraint
{
    /**
     * @param WebposRoleNew $webposRoleNew
     * @param $buttons
     */
    public function processAssert(WebposRoleNew $webposRoleNew, $buttons)
    {
        if ($buttons !== null) {
            $buttonArray = explode(",", $buttons);
            foreach ($buttonArray as $button) {
                \PHPUnit_Framework_Assert::assertTrue(
                    $webposRoleNew->getRoleFormPageActions()->actionButton(trim($button))->isVisible(),
                    'Action button ' . $button . ' is not available.'
                );
            }
        }
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Role form page action is visible.';
    }
}