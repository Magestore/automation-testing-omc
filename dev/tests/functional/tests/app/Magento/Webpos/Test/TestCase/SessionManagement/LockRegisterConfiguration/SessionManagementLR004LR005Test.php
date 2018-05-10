<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 3/12/2018
 * Time: 1:21 PM
 */

namespace Magento\Webpos\Test\TestCase\SessionManagement\LockRegisterConfiguration;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Page\Adminhtml\PosEdit;
use Magento\Webpos\Test\Page\Adminhtml\PosIndex;

class SessionManagementLR004LR005Test extends Injectable
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
        $this->assertTrue(
            $this->posEdit->getPosForm()->waitForElementVisible('[name="pin"][type="password"]'),
            'Security pin field is not visible.'
        );
        $this->posEdit->getPosForm()->getIsAllowToLockField()->setValue('No');
        $this->assertTrue(
            $this->posEdit->getPosForm()->waitForElementNotVisible('[name="pin"]'),
            'Security pin field is not hidden.'
        );
    }
}