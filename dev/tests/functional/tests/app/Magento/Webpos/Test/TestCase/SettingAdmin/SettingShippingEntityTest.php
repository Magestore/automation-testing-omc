<?php

/**
 * @Author: thomas
 * @Created At:   2017-09-14 07:40:06
 * @Email:  thomas@trueplus.vn
 * @Last Modified by:   thomas
 * @Last Modified time: 2017-10-11 10:18:39
 * @Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\TestCase\SettingAdmin;

/**
 * Steps:
 *
 * 1. Login to backend.
 * 2. Go to Stores -> Configuration -> Magestore Extension -> WebPos.
 * 3. Set "Allowspecific Shipping" to All Allowed Shipping.
 * 4. Set "Specific Shipping" to POS Shipping - Store Pickup.
 * 5. Set "Default Shipping" to POS Shipping - Store Pickup.
 * 6. Set "Enable Mark As Shipped Default" to Yes.
 *
 * @ZephyrId MAGETWO-46903
 */
class SettingShippingEntityTest extends \Magento\Webpos\Test\TestCase\SettingAdmin\SettingGeneralEntityTest
{
}
