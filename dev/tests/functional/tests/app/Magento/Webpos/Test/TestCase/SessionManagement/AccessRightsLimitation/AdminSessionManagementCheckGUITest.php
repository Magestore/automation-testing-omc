<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 25/05/2018
 * Time: 10:15
 */

namespace Magento\Webpos\Test\TestCase\SessionManagement\AccessRightsLimitation;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\SystemConfigEditSectionWebpos;

/**
 * Class AdminSessionManagementCheckGUITest
 * @package Magento\Webpos\Test\TestCase\SessionManagement\AccessRightsLimitation
 */
class AdminSessionManagementCheckGUITest extends Injectable
{
    /**
     * @var SystemConfigEditSectionWebpos $systemConfigEditSectionWebpos
     */
    protected $systemConfigEditSectionWebpos;

    public function __inject(
        SystemConfigEditSectionWebpos $systemConfigEditSectionWebpos
    )
    {
        $this->systemConfigEditSectionWebpos = $systemConfigEditSectionWebpos;
    }

    public function test()
    {
        $this->systemConfigEditSectionWebpos->open();
        $this->systemConfigEditSectionWebpos->getForm()->getGroup("webpos", "security");
    }
}