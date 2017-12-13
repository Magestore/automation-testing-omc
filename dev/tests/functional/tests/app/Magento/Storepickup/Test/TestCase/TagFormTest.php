<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/23/2017
 * Time: 9:13 AM
 */

namespace Magento\Storepickup\Test\TestCase;

use Magento\Mtf\TestCase\Injectable;
use Magento\Storepickup\Test\Fixture\StorepickupHoliday;
use Magento\Storepickup\Test\Fixture\StorepickupSchedule;
use Magento\Storepickup\Test\Fixture\StorepickupStore;
use Magento\Storepickup\Test\Fixture\StorepickupTag;
use Magento\Storepickup\Test\Page\Adminhtml\TagIndex;
use Magento\Search\Test\Fixture\SynonymGroup;
use Magento\User\Test\Fixture\User;
use Magento\Widget\Test\Fixture\Widget;
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

//    public function __prepare(StorepickupHoliday $storepickupTag)
//    {
//        $storepickupTag->persist();
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