<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/11/2017
 * Time: 2:37 PM
 */

namespace Magento\Storepickup\Test\Block\Adminhtml\Store\Edit\Tab\Schedule;

use Magento\Backend\Test\Block\Widget\Tab;
use Magento\Mtf\Client\Element\SimpleElement;
use Magento\Mtf\Client\Locator;

class ScheduleId extends Tab
{
    protected $tableLoader = '.schedule-table-loading.loading-mask';

    protected $scheduleTable = '.schedule-table-wrapper';

    public function setFieldsData(array $data, SimpleElement $element = null)
    {
        $scheduleSelect = $element->find('[name="schedule_id"]', Locator::SELECTOR_CSS, 'select');
        $scheduleSelect->setValue($data['schedule_id']['value']);
        $this->waitForElementNotVisible($this->tableLoader);
        $this->waitForElementVisible($this->scheduleTable);
        return $this;
    }
}