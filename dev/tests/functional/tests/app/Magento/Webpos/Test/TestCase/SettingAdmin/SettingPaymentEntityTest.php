<?php

/**
 * @Author: thomas
 * @Created At:   2017-09-14 07:52:15
 * @Email:  thomas@trueplus.vn
 * @Last Modified by:   thomas
 * @Last Modified time: 2017-10-11 10:18:18
 * @Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\TestCase\SettingAdmin;

/**
 * Steps:
 *
 * 1. Login to backend.
 * 2. Go to Stores -> Configuration -> Magestore Extension -> WebPos.
 * 3. Set "Specific Payment" to Web POS - Cash On Delivery.
 * 4. Set "Default Payment" to Web POS - Cash On Delivery.
 * 5. Set "Authorizenet Enable" to Yes.
 * 6. Set "Authorizenet Api login" to Authorizenet.
 * 7. Set "Authorizenet Transaction Key" to Transaction.
 * 8. Set "Authorizenet Client ID" to Client ID.
 * 9. Set "Authorizenet Payment Action" to Authorize and Capture.
 * 10. Set "Authorizenet Is Sandbox" to Yes.
 * 11. Set "paypal_enable" to Yes.
 * 12. Set "Paypal Client ID" to Your Application Client ID.
 * 13. Set "Paypal Client Secret" to Your Application Client Secret.
 * 14. Set "Paypal Is Sandbox" to Yes.
 * 15. Set "Paypal Enable Send Invoice" to Yes.
 * 16. Set "Paypal Enable Paypal here" to Yes.
 * 17. Set "Paypal Merchant Infomation Email" to thomas@trueplus.vn.
 * 18. Set "Paypal Merchant Infomation Firstname" to Thomas.
 * 19. Set "Paypal Merchant Infomation Lastname" to Edison.
 * 20. Set "Paypal Merchant Infomation Buisiness Name" to Mr.D.
 * 21. Set "Paypal Merchant Infomation Phone" to 01692804009.
 * 22. Set "Paypal Merchant Infomation Street" to Số nhà 21 Ngõ 286 Giáp Bát Phường Giáp Bát Quận Hoàng Mai.
 * 23. Set "Paypal Merchant Infomation City" to Hà Nội.
 * 24. Set "Paypal Merchant Infomation State" to Việt Nam.
 * 25. Set "Paypal Merchant Infomation Postal Code" to 100000.
 * 26. Set "Paypal Merchant Infomation Country Id" to Vietnam.
 * 27. Set "Stripe Enable" to Yes.
 * 28. Set "Stripe API Key" to Api Key.
 * 29. Set "Stripe Publishable Key" to Publishable Key.
 * 30. Set "Stripe Is Sandbox" to Yes.
 *
 * @ZephyrId MAGETWO-46903
 */
class SettingPaymentEntityTest extends \Magento\Webpos\Test\TestCase\SettingAdmin\SettingGeneralEntityTest
{
}
