<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 3/12/2018
 * Time: 2:24 PM
 */

namespace Magento\Webpos\Test\TestCase\SessionManagement\LockRegisterConfiguration;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Page\Adminhtml\PosEdit;
use Magento\Webpos\Test\Page\Adminhtml\PosIndex;

class SessionManagementLR008Test extends Injectable
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
        $this->posEdit->getPosForm()->getSecurityPinField()->setValue('');
        $this->posEdit->getFormPageActions()->save();
        $this->assertTrue(
            $this->posEdit->getPosForm()->getSecurityPinError()->isVisible(),
            'Security pin require error message is not visible'
        );
        $this->assertEquals(
            'This is a required field.',
            $this->posEdit->getPosForm()->getSecurityPinError()->getText(),
            'Require field message is wrong.'
        );
    }
}