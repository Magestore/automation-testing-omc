<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 3/16/2018
 * Time: 8:08 AM
 */

namespace Magento\Webpos\Test\TestCase\SessionManagement\LockRegisterConfiguration;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Page\Adminhtml\PosEdit;
use Magento\Webpos\Test\Page\Adminhtml\PosIndex;

class SessionManagementLR13Test extends Injectable
{
    /**
     * @var PosIndex
     */
    protected $posIndex;

    /**
     * @var PosEdit
     */
    protected $posEdit;

    public function __inject(PosIndex $posIndex, PosEdit $posEdit)
    {
        $this->posIndex = $posIndex;
        $this->posEdit = $posEdit;
    }

    public function test(Pos $pos)
    {
        $pos->persist();
        $this->posIndex->open();
        $this->posIndex->getPosGrid()->searchAndOpen(['pos_name' => $pos->getPosName()]);
        $this->posEdit->getPosForm()->getIsAllowToLockField()->setValue('Yes');
        $this->posEdit->getPosForm()->getSecurityPinField()->setValue('23567');
        $this->posEdit->getFormPageActions()->save();
        $this->assertTrue(
            $this->posEdit->getMessagesBlock()->isVisible(),
            'Alert message is not visible.'
        );
        $this->assertEquals(
            'Security PIN only contains 4 numeric characters in length. Please try again!',
            $this->posEdit->getMessagesBlock()->getErrorMessage(),
            'Alert message is wrong.'
        );
    }
}