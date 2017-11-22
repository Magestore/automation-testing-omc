<?php

namespace Magento\Giftvoucher\Test\Block\Adminhtml\Block\Giftcode;

use Magento\Mtf\Client\Element\SimpleElement;
use Magento\Ui\Test\Block\Adminhtml\DataGrid;
use Magento\Mtf\Client\Locator;

/**
 * Backend Data Grid for Giftcode Entity
 */
class GroupGrid extends DataGrid
{
    /**
     * Filters array mapping.
     *
     * @var array
     */
    protected $filters = [
        'giftvoucher_id_from' => [
            'selector' => '[name="giftvoucher_id[from]"]',
        ],
        'giftvoucher_id_to' => [
            'selector' => '[name="giftvoucher_id[to]"]',
        ],
        'gift_code' => [
            'selector' => '[name="gift_code"]',
        ],
        'history_amount_from' => [
            'selector' => '[name="history_amount[from]"]',
        ],
        'history_amount_to' => [
            'selector' => '[name="history_amount[to]"]',
        ],
        'balance_from' => [
            'selector' => '[name="balance[from]"]',
        ],
        'balance_to' => [
            'selector' => '[name="balance[to]"]',
        ],
        'status' => [
            'selector' => '[name="status"]',
            'input' => 'select',
        ],
        'customer_name' => [
            'selector' => '[name="customer_name"]',
        ],
        'order_increment_id' => [
            'selector' => '[name="order_increment_id"]',
        ],
        'recipient_name' => [
            'selector' => '[name="recipient_name"]',
        ],
        'created_at_from' => [
            'selector' => '[name="created_at[from]"]',
        ],
        'created_at_to' => [
            'selector' => '[name="created_at[to]"]',
        ],
        'expired_at_from' => [
            'selector' => '[name="expired_at[from]"]',
        ],
        'expired_at_to' => [
            'selector' => '[name="expired_at[to]"]',
        ],
        'store_id' => [
            'selector' => '[name="store_id"]',
            'input' => 'selectstore'
        ],
        'is_sent' => [
            'selector' => '[name="is_sent"]',
            'input' => 'select',
        ],
        'extra_content' => [
            'selector' => '[name="extra_content"]',
        ],
    ];

    /**
     * Locator value for select perpage element
     *
     * @var string
     */
    protected $perPage = '.admin__data-grid-pager-wrap .selectmenu';

    /**
     * Change per page
     *
     * @param number $pageSize
     */
    public function changePerPage($pageSize)
    {
        $selectmenu = $this->_rootElement->find($this->perPage);
        $selectmenu->find('.selectmenu-toggle')->click();

        $item = $selectmenu->find('.//button[@class="selectmenu-item-action" and text()="' . $pageSize . '"]', Locator::SELECTOR_XPATH);
        if ($item->isVisible()) {
            $item->click();
        }

        $this->waitLoader();
    }

    /**
     * Count the number of data-row
     *
     * @return number
     */
    public function getCountRows()
    {
        return count($this->_rootElement->getElements('tr.data-row'));
    }

    /**
     * @param string $id
     * @param string $headerLabel
     * @return array|string
     */
    public function getColumnValue($id, $headerLabel)
    {
        $this->waitLoader();
        $this->getTemplateBlock()->waitForElementNotVisible($this->loader);
        $columnNumber = count(
            $this->_rootElement->getElements(sprintf($this->columnNumber, $headerLabel), Locator::SELECTOR_XPATH)
        );
        $selector = sprintf($this->rowById, $id) . '//td';
        for ($i = $columnNumber; $i > 0; $i--) {
            $selector .= '//following-sibling::td';
        }
        $selector .= '//div';

        return $this->_rootElement->find($selector, Locator::SELECTOR_XPATH)->getText();
    }
}
