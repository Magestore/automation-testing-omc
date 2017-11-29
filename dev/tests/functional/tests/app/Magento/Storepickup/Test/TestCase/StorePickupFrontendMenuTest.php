<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/23/2017
 * Time: 2:42 PM
 */

namespace Magento\Storepickup\Test\TestCase;

use Magento\Cms\Test\Page\CmsIndex;
use Magento\Cms\Test\Page\CmsPage;
use Magento\Mtf\TestCase\Injectable;

/**
 * Class StorePickupFrontendMenuTest
 * @package Magento\Storepickup\Test\TestCase
 */
class StorePickupFrontendMenuTest extends Injectable
{
    /**
     * @var CmsIndex
     */
    protected $cmsIndex;

    /**
     * @param CmsIndex $cmsIndex
     */
    public function __inject(CmsIndex $cmsIndex)
    {
        $this->cmsIndex = $cmsIndex;
        $this->cmsPage = $cmsIndex;
    }

    /**
     *
     */
    public function test()
    {
        $this->cmsIndex->open();
        $this->cmsIndex->getLinksBlock()->openLink('Store pickup');
        $this->cmsIndex->getCmsPageBlock()->waitPageInit();
    }
}