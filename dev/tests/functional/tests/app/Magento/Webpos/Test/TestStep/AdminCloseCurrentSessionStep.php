<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 18/05/2018
 * Time: 08:44
 */

namespace Magento\Webpos\Test\TestStep;

use Magento\Mtf\TestStep\TestStepInterface;
use Magento\Webpos\Test\Page\Adminhtml\PosEdit;
use Magento\Webpos\Test\Page\Adminhtml\PosIndex;

/**
 * Class AdminCloseCurrentSessionStep
 * @package Magento\Webpos\Test\TestStep
 */
class AdminCloseCurrentSessionStep implements TestStepInterface
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

    public function __construct(PosIndex $posIndex, PosEdit $posEdit)
    {
        $this->posIndex = $posIndex;
        $this->posEdit = $posEdit;
    }

    /**
     * Run step flow
     *
     * @return mixed
     */
    public function run()
    {
        $this->posIndex->open();
        $this->posIndex->getPosGrid()->waitLoader();
        $this->posIndex->getPosGrid()->resetFilter();
        $this->posIndex->getPosGrid()->searchAndOpen([
            'pos_name' => 'Store POS'
        ]);
        $this->posEdit->getPosForm()->waitLoader();
        $this->posEdit->getPosForm()->getTabByTitle('Current Sessions Detail')->click();
        $this->posEdit->getPosForm()->waitForCurrentSessionVisible();
        if (!$this->posEdit->getPosForm()->getDefaultCurrentSession('There are 0 open session')->isVisible()) {
            $this->posEdit->getPosForm()->getSetClosingBalance()->click();
            $this->posEdit->getModalsWrapper()->getConfirmButton()->click();
            // confirm popup second
            if($this->posEdit->getModalsWrapper()->getConfirmButton()->isVisible())
            {
                $this->posEdit->getModalsWrapper()->getConfirmButton()->click();
            }
            $this->posEdit->getModalsWrapper()->waitForHidden();
//            sleep(1);
            $this->posEdit->getPosForm()->waitValidateClosingVisible();
            $this->posEdit->getPosForm()->getValidateClosing()->click();
            $this->posEdit->getPosForm()->waitForElementNotVisible('.loading-mask');
            $this->posEdit->getPosForm()->waitCloseSession();
        }
    }
}