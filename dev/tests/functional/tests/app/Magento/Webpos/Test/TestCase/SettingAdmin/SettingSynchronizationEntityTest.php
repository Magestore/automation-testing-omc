<?php

/**
 * @Author: thomas
 * @Created At:   2017-09-14 09:15:01
 * @Email:  thomas@trueplus.vn
 * @Last Modified by:   thomas
 * @Last Modified time: 2017-10-11 10:18:52
 * @Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\TestCase\SettingAdmin;

/**
 * Steps:
 *
 * 1. Login to backend.
 * 2. Go to Stores -> Configuration -> Magestore Extension -> WebPos.
 * 3. Set "Product Time" to 10 mins.
 * 4. Set "Stock Item Time" to 10 mins.
 * 5. Set "Customer Time" to 10 mins.
 * 6. Set "Order Time" to 10 mins.
 * 7. Set "Order Limit" to Last 3 months.
 *
 * @ZephyrId MAGETWO-46903
 */
class SettingSynchronizationEntityTest extends \Magento\Webpos\Test\TestCase\SettingAdmin\SettingGeneralEntityTest
{

}
