<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/14/18
 * Time: 4:24 PM
 */

namespace Magento\Webpos\Test\TestCase\Pos\MassAction;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\PosIndex;
use Magento\Webpos\Test\Page\Adminhtml\PosNews;

/**
 * Manage POS - Add POS
 * Testcase MP15 - Click on [Save] button without filling out all fields
 *
 * Precondition
 * - Empty
 *
 * Steps
 * 1. Go to backend > Sales > Manage POS
 * 2. Click on [Add POS] button
 * 3. Click on [Save] button
 *
 * Acceptance
 * 1. Create POS unsuccessfully
 * 2. Show message: "This is a required field." under [POS Name] field
 *
 * Class WebposManagePosMP15
 * @package Magento\Webpos\Test\TestCase\Pos\Filter
 */
class WebposManagePosMP15Test extends Injectable
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
        $this->posNews->getFormPageActions()->save();
    }
}