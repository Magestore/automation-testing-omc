<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 23/12/2017
 * Time: 19:20
 */
namespace Magento\BarcodeSuccess\Test\Block\Adminhtml\BarcodeHistory;
use Magento\Mtf\Client\Locator;
use Magento\BarcodeSuccess\Test\Block\Adminhtml\BarcodeGrid;
class BarcodeHistoryGrid extends BarcodeGrid
{
    protected $itemIdBarcodeHistory = '//*[@id="container"]/div/div[3]/table/tbody/tr[1]/td[1]/div
';
    protected  $filters = [
        'username' => [
            'selector' => '[name="username"]',
        ],
        'type' => [
            'selector' => '[name="type"]',
            'input' => 'select',
        ]
    ];
    public function getItemId()
    {
        //*[@id="container"]/div/div[3]/table/tbody/tr[1]/td[1]/div
        $this->waitLoader();
        $this->getTemplateBlock()->waitForElementNotVisible($this->loader);
        return $this->_rootElement->find($this->itemIdBarcodeHistory, Locator::SELECTOR_XPATH)->getText();
    }

}