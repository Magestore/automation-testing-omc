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

class TagFormTest extends Injectable
{
    /**
     * @var TagIndex
     */
    protected $tagIndex;

    public function __inject(TagIndex $tagIndex)
    {
        $this->tagIndex = $tagIndex;
    }

    public function test($button)
    {
        $this->tagIndex->open();
        $this->tagIndex->getButtonsGridPageActions()->clickActionButton($button);
    }
}