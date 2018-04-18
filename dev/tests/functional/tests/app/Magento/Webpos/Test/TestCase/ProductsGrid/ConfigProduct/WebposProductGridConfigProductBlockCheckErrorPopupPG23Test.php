<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 2/7/2018
 * Time: 9:37 AM
 */

namespace Magento\Webpos\Test\TestCase\ProductsGrid\ConfigProduct;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposProductGridCheckConfigProductBlockPG19Test
 * @package Magento\Webpos\Test\TestCase\ProductsGrid\ConfigProduct
 */
class  WebposProductGridConfigProductBlockCheckErrorPopupPG23Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    public function __inject(WebposIndex $webposIndex)
    {
        $this->webposIndex = $webposIndex;
    }

    public function test()
    {
        // Login webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        $this->webposIndex->getCheckoutProductList()->search('Abominable Hoodie');
        $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="popup-product-detail"]');
        sleep(5);
        $this->webposIndex->getCheckoutProductDetail()->getButtonAddToCart()->click();
        sleep(1);
        $this->assertEquals(
            'Please choose all options',
            $this->webposIndex->getModal()->getPopupMessage(),
            'Error popup message is wrong.'
        );
        $this->webposIndex->getModal()->getOkButton()->click();
        sleep(1);
        $this->assertFalse(
            $this->webposIndex->getModal()->isVisible(),
            'Error popup is not hidden.'
        );
        $this->webposIndex->getCheckoutProductDetail()->getButtonAddToCart()->click();
        sleep(1);
        $this->webposIndex->getModal()->getCloseButton()->click();
        sleep(1);
        $this->assertFalse(
            $this->webposIndex->getModal()->isVisible(),
            'Error popup is not hidden.'
        );

    }
}