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

class ManagePointBalancesFormTest extends Injectable
{
    /**
     * @var ManagePointBalancesIndex
     */
    protected $managePointBalancesIndex;

    public function __inject(ManagePointBalancesIndex $managePointBalancesIndex)
    {
        $this->managePointBalancesIndex = $managePointBalancesIndex;
    }

    public function test($button)
    {
        $this->managePointBalancesIndex->open();
        $this->managePointBalancesIndex->getButtonsGridPageActions()->clickActionButton($button);
    }
}