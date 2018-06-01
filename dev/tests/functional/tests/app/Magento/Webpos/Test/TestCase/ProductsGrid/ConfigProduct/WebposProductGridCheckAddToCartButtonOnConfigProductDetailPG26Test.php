<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 2/7/2018
 * Time: 9:37 AM
 */

namespace Magento\Webpos\Test\TestCase\ProductsGrid\ConfigProduct;

use Magento\Config\Test\TestStep\SetupConfigurationStep;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Mtf\TestStep\TestStepFactory;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposProductGridCheckConfigProductBlockPG19Test
 * @package Magento\Webpos\Test\TestCase\ProductsGrid\ConfigProduct
 *
 * Precondition:
 * 1. Login webpos as a staff
 *
 * Steps:
 * "1. Click on [View product details] (only swatch option)
 * 2. Click on [Add to cart] button
 * 3. Click on [OK] button on Error popup
 * 4. Click on [Add to cart] button again
 * 5. Click on [Close] button on Error popup"
 *
 * Acceptance:
 * "2. Show error popup with message: 'Please choose all options""
 * 3. Close the error popup
 * 5. Close the error popup"
 *
 */
class  WebposProductGridCheckAddToCartButtonOnConfigProductDetailPG26Test extends Injectable
{
    /**
     * Factory for creation SetupConfigurationStep.
     *
     * @var TestStepFactory
     */
    private $testStepFactory;
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    public function __inject(WebposIndex $webposIndex, TestStepFactory $testStepFactory)
    {
        $this->webposIndex = $webposIndex;
        $this->testStepFactory = $testStepFactory;
    }


    public function test(FixtureFactory $fixtureFactory)
    {

        $this->testStepFactory->create(
            SetupConfigurationStep::class,
            ['configData' => 'enable_swatches_visibility_in_catalog', 'flushCache' => true]
        )->run();

        $product = $fixtureFactory->createByCode('configurableProduct', ['dataset' => 'product_with_text_swatch']);
        $product->persist();

        // LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\SessionInstallStep'
        )->run();
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getCheckoutProductList()->search($product->getSku());
        $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="popup-product-detail"]');

        /** wait watches render */
        sleep(2);
        $this->webposIndex->getCheckoutProductDetail()->getButtonAddToCart()->click();
        sleep(1);

        $this->assertTrue(
            $this->webposIndex->getModal()->getPopupMessageElement()->isVisible(),
            'Error popup message is not showed.'
        );

        $this->assertEquals(
            'Please choose all options',
            $this->webposIndex->getModal()->getPopupMessage(),
            'Error popup message is wrong.'
        );
        $this->webposIndex->getModal()->getOkButton()->click();
        sleep(1);
        $this->assertFalse(
            $this->webposIndex->getModal()->getPopupMessageElement()->isVisible(),
            'Error popup is not hidden.'
        );
        $this->webposIndex->getCheckoutProductDetail()->getButtonAddToCart()->click();
        sleep(1);
        $this->webposIndex->getModal()->getCloseButton()->click();
        sleep(1);
        $this->assertFalse(
            $this->webposIndex->getModal()->getPopupMessageElement()->isVisible(),
            'Error popup is not hidden.'
        );

    }
}
