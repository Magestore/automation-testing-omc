<?php

namespace Magento\Webpos\Test\Block\Adminhtml\Denomination;

/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 12/5/2017
 * Time: 9:10 AM
 */
class DenominationIndex extends  \Magento\Backend\Test\Block\GridPageActions
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
    }
}