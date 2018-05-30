<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 10/05/2018
 * Time: 10:56
 */

namespace Magento\Webpos\Test\TestStep;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestStep\TestStepInterface;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposAddProductToCartThenCheckoutStep
 * @package Magento\Webpos\Test\TestStep
 */
class WebposAddProductToCartThenCheckoutStep implements TestStepInterface
{
    /**
     * Webpos Index page.
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;
    /**
     * @var FixtureFactory $fixtureFactory
     */
    protected $fixtureFactory;

    protected $products;

    /**
     * @var string $paymentMethod
     */
    protected $paymentMethod;

    /**
     * @var bool $setPaymentAmount
     */
    protected $setPaymentAmount;

    /**
     * @var string $paymentAmount
     */
    protected $paymentAmount;

    public function __construct(
        WebposIndex $webposIndex,
        FixtureFactory $fixtureFactory,
        $products,
        $paymentMethod = "cashforpos",
        $setPaymentAmount = false,
        $paymentAmount = '0'
    )
    {
        $this->webposIndex = $webposIndex;
        $this->fixtureFactory = $fixtureFactory;
        $this->products = $products;
        $this->paymentMethod = $paymentMethod;
        $this->setPaymentAmount = $setPaymentAmount;
        $this->paymentAmount = $paymentAmount;
    }

    public function run()
    {
        $i = 0;
        foreach ($this->products as $product) {
            $this->products[$i] = $this->fixtureFactory->createByCode('catalogProductSimple', ['dataset' => $product]);
            $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
            $this->webposIndex->getCheckoutProductList()->search($this->products[$i]->getSku());
            $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
            $this->webposIndex->getMsWebpos()->waitCartLoader();
            $i++;
        }

        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        switch ($this->paymentMethod) {
            case 'cashforpos':
                $this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
                break;
            case 'codforpos':
                $this->webposIndex->getCheckoutPaymentMethod()->getCashOnDeliveryMethod()->click();
                break;
            case 'ccforpos':
                $this->webposIndex->getCheckoutPaymentMethod()->getCreditCard()->click();
                break;
            case 'cp1forpos':
                $this->webposIndex->getCheckoutPaymentMethod()->getCustomPayment1()->click();
                break;
            case 'cp2forpos':
                $this->webposIndex->getCheckoutPaymentMethod()->getCustomPayment2()->click();
                break;
            default:
                $this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
        }
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        if ($this->setPaymentAmount &&
            $this->webposIndex->getCheckoutPaymentMethod()->getAmountPayment()->isVisible()) {
            $this->webposIndex->getCheckoutPaymentMethod()->getAmountPayment()->click();
            $this->webposIndex->getCheckoutPaymentMethod()->getAmountPayment()->setValue($this->paymentAmount);
            $this->webposIndex->getCheckoutPaymentMethod()->getTitlePaymentMethod()->click();
        }
        $paymentAmount = 0;
        if ($this->webposIndex->getCheckoutPaymentMethod()->getAmountPayment()->isVisible()) {
            $paymentAmount = $this->convertPriceFormatToDecimal($this->webposIndex->getCheckoutPaymentMethod()->getAmountPayment()->getValue());
        }
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        return [
            'paymentAmount' => $paymentAmount
        ];
    }

    /**
     * convert string price format to decimal
     * @param $string
     * @param $symbol
     * @return float|int|null
     */
    public function convertPriceFormatToDecimal($string, $symbol = '$')
    {
        $result = null;
        $negative = false;
        if ($string[0] === '-') {
            $negative = true;
            $string = str_replace('-', '', $string);
        }
        $string = str_replace($symbol, '', $string);
        $result = floatval($string);
        if ($negative) {
            $result = -1 * abs($result);
        }
        return $result;
    }
}