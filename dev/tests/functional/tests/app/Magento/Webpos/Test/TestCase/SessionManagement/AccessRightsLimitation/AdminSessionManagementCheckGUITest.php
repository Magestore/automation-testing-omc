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
 *
 * Precondition:
 * - Loged in webpos
 * - Go to webpos setting page (path: Sales -> under Webpos, select Settings -> open Security session)
 *
 * Steps:
 * 1. In the Security session, check the component of configuration
 *
 * Acceptance:
 * The conponent of configuration include:
 * + 1 field label:  POS Account Sharing
 * + 1 dropdown with 2 options: Yes, No
 * + 1 textguide "
 * If set to Yes, you can log in from multiple computers into same account. Default setting No improves security." is located under the POS Account Sharing field
 *
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