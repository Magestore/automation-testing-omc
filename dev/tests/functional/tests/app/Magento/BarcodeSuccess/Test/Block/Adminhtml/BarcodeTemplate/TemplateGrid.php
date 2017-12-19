<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 05/12/2017
 * Time: 16:55
 */
namespace Magento\BarcodeSuccess\Test\Block\Adminhtml\BarcodeTemplate;
use Magento\Mtf\Client\Locator;
use Magento\BarcodeSuccess\Test\Block\Adminhtml\BarcodeGrid;

class TemplateGrid extends BarcodeGrid
{
    protected $filters = [
        'name' => [
            'selector' => '[name="name"]',
        ],
        'type' => [
            'selector' => '[name="type_id"]',
            'input' => 'select',
        ],
        'status' => [
            'selector' => '[name="status"]',
            'input' => 'select',
        ],
    ];

    private $gridHeader = './/div[@class="admin__data-grid-header"][(not(ancestor::*[@class="sticky-header"]) and not(contains(@style,"visibility: hidden"))) or (ancestor::*[@class="sticky-header" and not(contains(@style,"display: none"))])]';

    private function getGridHeaderElement()
    {
        return $this->_rootElement->find($this->gridHeader, Locator::SELECTOR_XPATH);
    }
    public function selectActionWithAlert($action, $option = null)
    {
        $actionType = is_array($action) ? key($action) : $action;
        $this->getGridHeaderElement()->find($this->actionButton)->click();
        $this->getGridHeaderElement()
            ->find(sprintf($this->actionList, $actionType), Locator::SELECTOR_XPATH)
            ->click();
        if (is_array($action)) {
            $this->getGridHeaderElement()
                ->find(sprintf($this->actionList, end($action)), Locator::SELECTOR_XPATH)
                ->click();
        }
        if($option == null){
            $element = $this->browser->find($this->alertModal);
            /** @var \Magento\Ui\Test\Block\Adminhtml\Modal $modal */
            $modal = $this->blockFactory->create(
                \Magento\Ui\Test\Block\Adminhtml\Modal::class,
                ['element' => $element]
            );
            $modal->acceptAlert();
        }else {
            $this->getGridHeaderElement()
                ->find(sprintf($this->actionList, $option), Locator::SELECTOR_XPATH)
                ->click();
        }

    }
}