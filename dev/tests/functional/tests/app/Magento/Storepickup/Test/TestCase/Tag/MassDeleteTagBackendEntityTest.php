<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/19/2017
 * Time: 2:21 PM
 */

namespace Magento\Storepickup\Test\TestCase\Tag;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Storepickup\Test\Page\Adminhtml\TagIndex;

/**
 *
 * Test Flow:
 * Preconditions:
 * 1. Create X tags
 *
 * Steps:
 * 1. Open backend
 * 2. Go to  Store Pickup > Manage Tag
 * 3. Select N tags from preconditions
 * 4. Select in dropdown "Delete"
 * 5. Accept alert
 * 6. Perform all assertions according to dataset
 *
 */
class MassDeleteTagBackendEntityTest extends Injectable
{
    /**
     * @var FixtureFactory
     */
    protected $fixtureFactory;

    /**
     * @var TagIndex
     */
    protected $tagIndex;

    /**
     * @param FixtureFactory $fixtureFactory
     * @param TagIndex $tagIndex
     */
    public function __inject(
        FixtureFactory $fixtureFactory,
        TagIndex $tagIndex
    ){
        $this->fixtureFactory = $fixtureFactory;
        $this->tagIndex = $tagIndex;
        $tagIndex->open();
        $tagIndex->getTagGrid()->massaction([], 'Delete', true, 'Select All');
    }

    public function test($tagsQty, $tagsQtyToDelete)
    {
        $tags = $this->createTags($tagsQty);
        $deleteTags = [];
        for ($i = 0; $i < $tagsQtyToDelete; $i++) {
            $deleteTags[] = ['name' => $tags[$i]->getTagName()];
        }
        $this->tagIndex->open();
        $this->tagIndex->getTagGrid()->massaction($deleteTags, 'Delete', true);

        return ['tags' => $tags];
    }

    public function createTags($tagsQty)
    {
        $tags = [];
        for ($i = 0; $i < $tagsQty; $i++) {
            $tag = $this->fixtureFactory->createByCode('storepickupTag', ['dataset' => 'default1']);
            $tag->persist();
            $tags[] = $tag;
        }
        return $tags;
    }

}