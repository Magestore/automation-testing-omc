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

class WebposAddProductToCartThenCheckoutStep implements TestStepInterface
{
    /**
     * Webpos Index page.
     * @var WebposIndex
     */
    protected $webposIndex;
    /**
     * @var FixtureFactory
     */
    protected $fixtureFactory;

    protected $products;

    protected $paymentMethod;

    public function __construct(
        WebposIndex $webposIndex,
        FixtureFactory $fixtureFactory,
        $products,
        $paymentMethod = "cashforpos"
    )
    {
        $this->webposIndex = $webposIndex;
        $this->fixtureFactory = $fixtureFactory;
        $this->products = $products;
        $this->paymentMethod = $paymentMethod;
    }

    public function run()
    {
        $i = 0;
        foreach ($this->products as $product) {
            $this->products[$i] = $this->fixtureFactory->createByCode('catalogProductSimple', ['dataset' => $product]);
            $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
            $this->webposIndex->getCheckoutProductList()->search($this->products[$i]->getSku());
            $this->webposIndex->getMsWebpos()->waitCartLoader();
            sleep(1);
            $i++;
        }

        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        switch ($this->paymentMethod){
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
        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
    }
}