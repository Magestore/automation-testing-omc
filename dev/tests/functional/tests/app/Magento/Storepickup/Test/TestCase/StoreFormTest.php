<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/23/2017
 * Time: 9:05 AM
 */

namespace Magento\Storepickup\Test\TestCase;

use Magento\Mtf\TestCase\Injectable;
use Magento\Storepickup\Test\Page\Adminhtml\StoreIndex;

class StoreFormTest extends Injectable
{
    /**
     * @var StoreIndex;
     */
    protected $storeIndex;

    public function __inject(StoreIndex $storeIndex)
    {
        $this->storeIndex = $storeIndex;
    }

    public function test($button)
    {
        $this->storeIndex->open();
        $this->storeIndex->getStoreGridPageActions()->clickActionButton($button);
    }
}