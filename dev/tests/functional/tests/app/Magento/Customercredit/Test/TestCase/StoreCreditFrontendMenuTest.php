<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/28/2017
 * Time: 3:19 PM
 */

namespace Magento\Customercredit\Test\TestCase;

use Magento\Cms\Test\Page\CmsIndex;
use Magento\Mtf\TestCase\Injectable;

/**
 * Class StoreCreditFrontendMenuTest
 * @package Magento\Customercredit\Test\TestCase
 */
class StoreCreditFrontendMenuTest extends Injectable
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
    }

    public function test()
    {
        $this->cmsIndex->open();
        $this->cmsIndex->getLinksBlock()->openLink('Buy Store Credit');
        $this->cmsIndex->getCmsPageBlock()->waitPageInit();
    }
}