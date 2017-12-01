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

/**
 * Class StoreFormTest
 * @package Magento\Storepickup\Test\TestCase
 */
class StoreFormTest extends Injectable
{
    /**
     * @var StoreIndex;
     */
    protected $storeIndex;

    /**
     * @param StoreIndex $storeIndex
     */
    public function __inject(StoreIndex $storeIndex)
    {
        $this->storeIndex = $storeIndex;
    }

    /**
     * @param $button
     */
    public function test($button)
    {
        $this->storeIndex->open();
        $this->storeIndex->getStoreGridPageActions()->clickActionButton($button);
        $this->storeIndex->getStoreGrid()->waitingForGridNotVisible();
    }
}