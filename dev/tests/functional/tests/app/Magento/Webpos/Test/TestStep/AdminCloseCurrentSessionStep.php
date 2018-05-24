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
        $this->posEdit->getPosForm()->getTabByTitle('Current Sessions Detail')->click();
        $this->posEdit->getPosForm()->waitForCurrentSessionVisible();
        if (!$this->posEdit->getPosForm()->getDefaultCurrentSession('There are 0 open session')->isVisible()) {
            $this->posEdit->getPosForm()->getSetClosingBalance()->click();
            $this->posEdit->getModalsWrapper()->getConfirmButton()->click();
            // sleep de cho modal set reason hien
            sleep(1);
            $this->posEdit->getModalsWrapper()->getConfirmButton()->click();
            $this->posEdit->getModalsWrapper()->waitForHidden();
            // sleep de cho button validate closing hien
            sleep(1);
            $this->posEdit->getPosForm()->getValidateClosing()->click();
            $this->posEdit->getPosForm()->waitForElementNotVisible('.loading-mask');
            $this->posEdit->getPosForm()->waitCloseSession();
        }
    }
}