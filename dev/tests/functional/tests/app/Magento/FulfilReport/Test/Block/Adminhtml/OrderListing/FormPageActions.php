<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 23/11/2017
 * Time: 08:49
 */

namespace Magento\FulfilReport\Test\Block\Adminhtml\OrderListing;

use Magento\Backend\Test\Block\FormPageActions as ParentFormPageActions;
/**
 * Class FormPageActions
 * @package Magento\FulfilReport\Test\Block\Adminhtml\OrderListing
 */
class FormPageActions extends ParentFormPageActions
{
    /**
     * "Add New" button
     *
     * @var string
     */
    protected $addNewButton = '#add';

    /**
     * Click on "Add New" button
     *
     * @return void
     */
    public function addNew()
    {
        $this->_rootElement->find($this->addNewButton)->click();
    }
}