<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/23/2017
 * Time: 9:13 AM
 */

namespace Magento\Storepickup\Test\TestCase;

use Magento\Mtf\TestCase\Injectable;
use Magento\Storepickup\Test\Page\Adminhtml\TagIndex;
use Magento\InventorySuccess\Test\Fixture\Warehouse;
/**
 * Class TagFormTest
 * @package Magento\Storepickup\Test\TestCase
 */
class TagFormTest extends Injectable
{
    /**
     * @var TagIndex
     */
    protected $tagIndex;

    /**
     * @param TagIndex $tagIndex
     */
    public function __inject(TagIndex $tagIndex)
    {
        $this->tagIndex = $tagIndex;
    }

//    public function __prepare(Warehouse $warehouse)
//    {
//        $warehouse->persist();
//    }

    /**
     * @param $button
     */
    public function test($button)
    {
        $this->tagIndex->open();
        $this->tagIndex->getTagGridPageActions()->clickActionButton($button);
        $this->tagIndex->getTagGrid()->waitingForGridNotVisible();
    }
}