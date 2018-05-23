<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/14/18
 * Time: 4:24 PM
 */

namespace Magento\Webpos\Test\TestCase\Pos\AddPos;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\PosIndex;
use Magento\Webpos\Test\Page\Adminhtml\PosNews;

/**
 * Manage POS - Add POS
 * Testcase MP23 - Check [Back] button
 *
 * Precondition
 * - Empty
 *
 * Steps
 * 1. Go to backend > Sales > Manage POS
 * 2. Click on [Add POS] button
 * 4. Click on [Back] button
 *
 * Acceptance
 * 3. Back to Manage POS page
 *
 * Class WebposManagePosMP23
 * @package Magento\Webpos\Test\TestCase\Pos\Filter
 */
class WebposManagePosMP23Test extends Injectable
{
    /**
     * Pos Index Page
     *
     * @var $posIndex
     */
    private $posIndex;

    private $posNews;

    public function __inject(PosIndex $posIndex, PosNews $posNews)
    {
        $this->posIndex = $posIndex;
        $this->posNews = $posNews;
    }

    public function test()
    {
        //Steps
        $this->posIndex->open();
        $this->posIndex->getPosGrid()->waitLoader();
        $this->posIndex->getPageActionsBlock()->addNew();
        $this->posNews->getPosForm()->waitLoader();
        $this->posNews->getFormPageActions()->getButtonByname('Back')->click();
        $this->posIndex->getPosGrid()->waitLoader();
        \PHPUnit_Framework_Assert::assertTrue(
            $this->posIndex->getPosGrid()->isVisible(),
            'Pos Index page didn\'t still display'
        );
    }
}