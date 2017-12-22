<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/24/2017
 * Time: 2:59 PM
 */

namespace Magento\Customercredit\Test\Block\Adminhtml\CustomerCredit;

use Magento\Customercredit\Test\Block\Adminhtml\CreditDataGrid;
use Magento\Mtf\Client\Element\SimpleElement;
use Magento\Mtf\Client\Locator;

/**
 * Class CustomerCreditGrid
 * @package Magento\Customercredit\Test\Block\Adminhtml\CustomerCredit
 */
class CustomerCreditGrid extends CreditDataGrid
{
    protected $selectItem = 'tbody tr td';
    /**
     * First row selector.
     *
     * @var string
     */
    protected $firstRowSelector = '//tr[@data-role="row"]/td[@data-column="rule_id"]';

    /**
     * Column header locator.
     *
     * @var string
     */
    protected $columnHeader = './/*[@id="customercreditGrid"]//th/span[.="%s"]';

    protected $filters = [
        'id_from' => [
            'selector' => '[name="entity_id[from]"]'
        ],
        'id_to' => [
            'selector' => '[name="entity_id[to]"]'
        ],
        'name' => [
            'selector' => '[name="name"]'
        ],
        'email' => [
            'selector' => '[name="email"]'
        ],
    ];

    /**
     * Return row with given catalog price rule name.
     *
     * @param string $ruleName
     * @return SimpleElement
     */
    public function getGridRow($ruleName)
    {
        return $this->getRow(['name' => $ruleName]);
    }

    /**
     * Return id of catalog price rule with given name.
     *
     * @param string $ruleName
     * @return string
     */
    public function getCatalogPriceId($ruleName)
    {
        return $this->getGridRow($ruleName)->find('//td[@data-column="rule_id"]', Locator::SELECTOR_XPATH)->getText();
    }

    /**
     * Check if specific row exists in grid.
     *
     * @param array $filter
     * @param bool $isSearchable
     * @param bool $isStrict
     * @return bool
     */
    public function isRowVisible(array $filter, $isSearchable = true, $isStrict = true)
    {
//        $this->search(['name' => $filter['name']]);
        return parent::isRowVisible($filter, $isSearchable, $isStrict);
    }

    public function getAllIds()
    {
        $this->waitLoader();
        $this->getTemplateBlock()->waitForElementNotVisible($this->loader);
        $rowsCheckboxes = $this->_rootElement->getElements($this->selectItem);
        $ids = [];
        foreach ($rowsCheckboxes as $checkbox) {
            $ids[] = $checkbox->getText();
        }
        return $ids;
    }

    /**
     * Sort grid by column.
     *
     * @param string $columnLabel
     */
    public function sortByColumn($columnLabel)
    {
        $this->waitLoader();
        $this->getTemplateBlock()->waitForElementNotVisible($this->loader);
        $this->_rootElement->find(sprintf($this->columnHeader, $columnLabel), Locator::SELECTOR_XPATH)->click();
        $this->waitLoader();
    }


    /**
     * @return array|string
     */
    public function getFirstItemId()
    {
        $this->waitLoader();
        $this->getTemplateBlock()->waitForElementNotVisible($this->loader);
        return $this->_rootElement->find($this->selectItem)->getText();
    }
}