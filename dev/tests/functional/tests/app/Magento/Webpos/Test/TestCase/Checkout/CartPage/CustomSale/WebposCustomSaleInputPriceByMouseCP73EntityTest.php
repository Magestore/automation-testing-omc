<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 1/11/2018
 * Time: 1:52 PM
 */

namespace Magento\Webpos\Test\TestCase\Checkout\CartPage\CustomSale;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposCustomSaleInputPriceByMouseCP73EntityTest
 * @package Magento\Webpos\Test\TestCase\Checkout\CartPage\CustomSale
 */
class WebposCustomSaleInputPriceByMouseCP73EntityTest extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * @param WebposIndex $webposIndex
     * @return void
     */
    public function __inject(
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
    }

    /**
     * @param $productName
     * @param $productDescription
     */
    public function test($productName, $productDescription)
    {
        $staff = $this->objectManager->create(
            '\Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $this->webposIndex->getCheckoutProductList()->getCustomSaleButton()->click();
        $this->webposIndex->getCheckoutCustomSale()->getProductNameInput()->setValue($productName);
        $this->webposIndex->getCheckoutCustomSale()->getDescriptionInput()->setValue($productDescription);
        //click mouse number field price
        $this->webposIndex->getCheckoutCustomSale()->getNumberField(5)->click();
        $this->webposIndex->getCheckoutCustomSale()->getNumberField(0)->click();
        $this->webposIndex->getCheckoutCustomSale()->getNumberField(0)->click();
        $this->webposIndex->getCheckoutCustomSale()->getNumberField(0)->click();
        sleep(2);
        $this->webposIndex->getCheckoutCustomSale()->getAddToCartButton()->click();
    }
}