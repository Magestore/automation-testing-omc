<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 24/05/2018
 * Time: 16:23
 */

namespace Magento\Webpos\Test\TestStep;

use Magento\Mtf\TestStep\TestStepInterface;
use Magento\Webpos\Test\Page\Adminhtml\PosEdit;
use Magento\Webpos\Test\Page\Adminhtml\PosIndex;

/**
 * Class AdminLockPosStep
 * @package Magento\Webpos\Test\TestStep
 */
class AdminLockPosStep implements TestStepInterface
{
    /**
     * Pos Index Page
     *
     * @var PosIndex
     */
    protected $posIndex;

    /**
     * Pos Edit page
     *
     * @var PosEdit
     */
    protected $posEdit;

    protected $posName;

    /**
     * AdminCloseCurrentSessionStep constructor.
     * @param PosIndex $posIndex
     * @param PosEdit $posEdit
     * @param string $posName
     */
    public function __construct(PosIndex $posIndex, PosEdit $posEdit, $posName = 'Store POS')
    {
        $this->posIndex = $posIndex;
        $this->posEdit = $posEdit;
        $this->posName = $posName;
    }

    /**
     * @return mixed|void
     * @throws \Exception
     */
    public function run()
    {
        $this->posIndex->open();
        $this->posIndex->getPosGrid()->waitLoader();
        $this->posIndex->getPosGrid()->resetFilter();
        $this->posIndex->getPosGrid()->searchAndOpen([
            'pos_name' => $this->posName
        ]);
        $this->posEdit->getPosForm()->waitLoader();
        $this->posEdit->getFormPageActions()->getLockButton()->click();
        \PHPUnit_Framework_Assert::assertEquals(
            $this->posName . ' was locked successfully.',
            $this->posEdit->getMessagesBlock()->getSuccessMessage(),
            'Success lock message is wrong.'
        );
    }
}