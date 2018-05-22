<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/14/18
 * Time: 4:24 PM
 */

namespace Magento\Webpos\Test\TestCase\Pos\AddPos;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Page\Adminhtml\PosIndex;
use Magento\Webpos\Test\Page\Adminhtml\PosNews;

/**
 * Manage POS - Add POS
 * Testcase MP22 - Check [Reset] button
 *
 * Precondition
 * - Empty
 *
 * Steps
 * 1. Go to backend > Sales > Manage POS
 * 2. Click on [Add POS] button
 * 3. Fill out correctly all fields
 * 4. Click on [Reset] button
 *
 * Acceptance
 * 4. Reset data in all fileds to default values
 *
 * Class WebposManagePosMP22
 * @package Magento\Webpos\Test\TestCase\Pos\Filter
 */
class WebposManagePosMP22Test extends Injectable
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

    public function test(Pos $pos)
    {
        //Steps
        $this->posIndex->open();
        $this->posIndex->getPosGrid()->waitLoader();
        $this->posIndex->getPageActionsBlock()->addNew();
        $this->posNews->getPosForm()->waitLoader();
        $this->posNews->getPosForm()->fill($pos);
        $this->posNews->getFormPageActions()->getResetButton()->click();
    }
}