<?php
namespace Magento\Webpos\Test\TestCase\Pos\PosForm;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\PosIndex;
use Magento\Webpos\Test\Page\Adminhtml\PosNews;

/**
 * TestCase MP02
 * Manage Pos-CheckGUI-Manage Pos page
 *
 * Precondition
 * Goto Backend
 *
 * Steps
 * 1.Go to Sales > Manage Pos
 * 2.Click [Add POS] button
 *
 * Class WebposManagePosMP02Test
 * @package Magento\Webpos\Test\TestCase\Pos\PosForm
 */
class WebposManagePosMP02Test extends Injectable
{
    /**
     * Webpos Pos Index Page
     * @var $_posIndexs
     */
    protected $_posIndex;

    /**
     * Webpos Pos New Page
     *
     * @var $_posNews
     */
    protected $_posNews;

    public function __inject(PosIndex $posIndex, PosNews $posNews){
        $this->_posIndex = $posIndex;
        $this->_posNews = $posNews;
    }

    public function test(){
        $this->_posIndex->open();
        $this->_posIndex->getPageActionsBlock()->addNew();
        sleep(2);
    }

}