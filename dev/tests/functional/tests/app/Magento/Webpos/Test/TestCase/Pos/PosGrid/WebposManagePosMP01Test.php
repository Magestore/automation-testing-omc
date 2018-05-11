<?php
namespace Magento\Webpos\Test\TestCase\Pos\PosGrid;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\PosIndex;

/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 4/27/18
 * Time: 8:18 AM
 */

/**
 * TestCase MP01
 * Manage Pos-CheckGUI-Manage Pos page
 *
 * Precondition
 * Goto Backend
 *
 * Steps
 * 1.Go to Sales > Manage Pos
 *
 *
 * Class WebposManagePosMP01Test
 * @package Magento\Webpos\Test\TestCase\Pos\PosGrid
 */
class WebposManagePosMP01Test extends Injectable
{
    /**
     * Webpos Pos Index Page
     * @var $_posIndexs
     */
    protected $_posIndex;

    public function __inject(PosIndex $posIndex){
        $this->_posIndex = $posIndex;
    }

    public function test(){
        $this->_posIndex->open();
        $this->_posIndex->getPosGrid()->waitLoader();
    }

}