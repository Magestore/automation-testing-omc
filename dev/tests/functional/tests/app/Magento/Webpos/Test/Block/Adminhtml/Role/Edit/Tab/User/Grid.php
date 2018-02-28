<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 08/09/2017
 * Time: 08:55
 */

namespace Magento\Webpos\Test\Block\Adminhtml\Role\Edit\Tab\User;

use Magento\Backend\Test\Block\Widget\Grid as AbstractGrid;
use Magento\Mtf\Client\Locator;

/**
 * Class Grid
 * Users grid in roles users tab
 */
class Grid extends AbstractGrid
{
	/**
	 * Grid filters' selectors
	 *
	 * @var array
	 */
	protected $filters = [
		'in_staff' => [
			'selector' => '[name="in_staff"]',
		],
		'staff_id_from' => [
			'selector' => '[name="staff_id[from]"]',
		],
		'staff_id_to' => [
			'selector' => '[name="staff_id[to]"]',
		],
		'username' => [
			'selector' => '[name="username"]',
		],
		'user_display_name' => [
			'selector' => '[name="user_display_name"]',
		],
		'email' => [
			'selector' => '[name="email"]',
		],
		'status' => [
			'selector' => '[name="status"]',
            'input' => 'select'
		],
	];

	/**
	 * Locator value for role name column
	 *
	 * @var string
	 */
	protected $selectItem = '.col-in_staff input';

    /**
     * Column header locator.
     *
     * @var string
     */
    protected $columnHeader = './/*[@id="staff_grid_table"]//th/span[.="%s"]';

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
        return $this->_rootElement->find($this->selectItem)->getValue();
    }

    public function clickSearchButton()
    {
        $this->_rootElement->find($this->searchButton, Locator::SELECTOR_CSS)->click();
        $this->waitLoader();
    }

    public function getEmptyText()
    {
        return $this->_rootElement->find('.empty-text', Locator::SELECTOR_CSS);
    }
}