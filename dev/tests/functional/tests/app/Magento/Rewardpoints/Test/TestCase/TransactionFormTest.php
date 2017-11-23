<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/23/2017
 * Time: 8:48 AM
 */

namespace Magento\Rewardpoints\Test\TestCase;

use Magento\Mtf\TestCase\Injectable;
use Magento\Rewardpoints\Test\Page\Adminhtml\TransactionIndex;

class TransactionFormTest extends Injectable
{
    /**
     * @var TransactionIndex
     */
    public $transactionIndex;

    public function __inject(TransactionIndex $transactionIndex)
    {
        $this->transactionIndex = $transactionIndex;
    }

    public function test($button)
    {
        $this->transactionIndex->open();
        $this->transactionIndex->getButtonsGridPageActions()->clickActionButton($button);
    }
}