<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 3/1/2018
 * Time: 11:10 AM
 */

namespace Magento\Webpos\Test\Constraint\Role;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleNew;

class AssertRoleSuccessSaveMessageOnRoleNewPage extends AbstractConstraint
{
    const SUCCESS_MESSAGE = 'Role was successfully saved';

    /**
     * Check Success Save Message for Synonyms.
     *
     * @param WebposRoleNew $webposRoleNew
     * @return void
     */
    public function processAssert(WebposRoleNew $webposRoleNew)
    {
        $actualMessage = $webposRoleNew->getMessagesBlock()->getSuccessMessage();
        \PHPUnit_Framework_Assert::assertEquals(
            self::SUCCESS_MESSAGE,
            $actualMessage,
            'Wrong success message is displayed.'
            . "\nExpected: " . self::SUCCESS_MESSAGE
            . "\nActual: " . $actualMessage
        );
    }

    /**
     * Text success save message is displayed
     *
     * @return string
     */
    public function toString()
    {
        return 'Assert that success message is displayed.';
    }
}