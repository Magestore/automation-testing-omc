<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/23/2017
 * Time: 8:40 AM
 */

namespace Magento\Rewardpoints\Test\TestCase;

use Magento\Mtf\TestCase\Injectable;
use Magento\Rewardpoints\Test\Page\Adminhtml\ManagePointBalancesIndex;

/**
 * Class ManagePointBalancesFormTest
 * @package Magento\Rewardpoints\Test\TestCase
 */
class ManagePointBalancesFormTest extends Injectable
{
    /**
     * @var ManagePointBalancesIndex
     */
    protected $managePointBalancesIndex;

    /**
     * @param ManagePointBalancesIndex $managePointBalancesIndex
     */
    public function __inject(ManagePointBalancesIndex $managePointBalancesIndex)
    {
        $this->managePointBalancesIndex = $managePointBalancesIndex;
    }

    /**
     * @param $button
     */
    public function test($button)
    {
        $this->managePointBalancesIndex->open();
        $this->managePointBalancesIndex->getManagePointBalancesGridPageActions()->clickActionButton($button);
    }
}