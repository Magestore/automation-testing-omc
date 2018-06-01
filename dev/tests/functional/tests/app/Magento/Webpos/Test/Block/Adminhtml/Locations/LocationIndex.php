<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 23/11/2017
 * Time: 10:53
 */

namespace Magento\Webpos\Test\Block\Adminhtml\Locations;

/**
 * Class LocationIndex
 * @package Magento\Webpos\Test\Block\Adminhtml\Locations
 */
class LocationIndex extends  \Magento\Backend\Test\Block\GridPageActions
{
    /**
     * "Mapping" button
     *
     * @var string
     */
    protected $mappingButton = '#mapping';

    /**
     * Click on "Mapping" button
     *
     * @return void
     */
    public function mappingButton()
    {
        $this->_rootElement->find($this->mappingButton)->click();
        $this->waitForElementNotVisible('.admin__form-loading-mask');
    }

}