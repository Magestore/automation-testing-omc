<?php

/**
 * @Author: thomas
 * @Created At:   2017-09-14 10:16:59
 * @Email:  thomas@trueplus.vn
 * @Last Modified by:   thomas
 * @Last Modified time: 2017-10-11 10:19:10
 * @Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\TestCase\SettingAdmin;

/**
 * Steps:
 *
 * 1. Login to backend.
 * 2. Go to Stores -> Configuration -> Magestore Extension -> WebPos.
 * 3. Set "webpos_color" to Blue.
 * 4. Set "enable_delivery_date" to Yes.
 * 5. Set "session_timeout" to 31536000.
 * 6. Set "ignore_checkout" to No.
 * 7. Set "enable_pole_display" to Yes.
 * 8. Set "enable_session" to Yes.
 * 9. Set "confirm_delete_order" to Yes.
 * 10. Set "active_key" to Thomas.
 * 11. Set "custom_sale_default_tax_class" to Taxable Goods.
 *
 * @ZephyrId MAGETWO-46903
 */
class SettingWebposGeneralEntityTest extends \Magento\Webpos\Test\TestCase\SettingAdmin\SettingGeneralEntityTest
{

}
