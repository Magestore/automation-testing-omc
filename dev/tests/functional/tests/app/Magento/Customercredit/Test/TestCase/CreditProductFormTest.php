<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/22/2017
 * Time: 3:41 PM
 */

namespace Magento\Customercredit\Test\TestCase;

use Magento\Mtf\TestCase\Injectable;
use Magento\Customercredit\Test\Page\Adminhtml\CreditProductIndex;

/**
 * Class CreditProductFormTest
 * @package Magento\Customercredit\Test\TestCase
 */
class CreditProductFormTest extends Injectable
{
    /**
     * @var CreditProductIndex
     */
    protected $creditProductIndex;

    /**
     * @param CreditProductIndex $creditProductIndex
     */
    public function __inject(CreditProductIndex $creditProductIndex)
    {
        $this->creditProductIndex = $creditProductIndex;
    }

    /**
     * @param string $button
     */
    public function test($button)
    {
        $this->creditProductIndex->open();
        $this->creditProductIndex->getButtonsGridPageActions()->clickActionButton($button);
    }
}