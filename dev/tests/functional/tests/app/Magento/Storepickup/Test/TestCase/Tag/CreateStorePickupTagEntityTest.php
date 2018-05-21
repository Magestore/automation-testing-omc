<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 12/6/2017
 * Time: 5:45 PM
 */

namespace Magento\Storepickup\Test\TestCase\Tag;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Storepickup\Test\Fixture\StorepickupTag;
use Magento\Storepickup\Test\Page\Adminhtml\TagIndex;
use Magento\Storepickup\Test\Page\Adminhtml\TagNew;

/**
 * Steps:
 * 1. LoginTest to the backend.
 * 2. Navigate to Store Pickup > Manage Tag.
 * 3. Start to Add New Tag .
 * 4. Fill in data according to data set.
 * 5. Save Tag.
 * 6. Perform appropriate assertions.
 *
 */
class CreateStorePickupTagEntityTest extends Injectable
{
    /**
     * @var TagIndex
     */
    protected $tagIndex;

    /**
     * @var TagNew
     */
    protected $tagNew;

    /**
     * @param TagIndex $tagIndex
     * @param TagNew $tagNew
     */
    public function __inject(TagIndex $tagIndex, TagNew $tagNew)
    {
        $this->tagIndex = $tagIndex;
        $this->tagNew = $tagNew;
    }

    /**
     * @param StorepickupTag $storepickupTag
     */
    public function test(StorepickupTag $storepickupTag)
    {
        $this->tagIndex->open();
        $this->tagIndex->getTagGridPageActions()->clickActionButton('add');
        $this->tagNew->getTagForm()->fill($storepickupTag);
        $this->tagNew->getTagFormPageActions()->save();
    }
}