<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 1/19/2018
 * Time: 3:22 PM
 */

namespace Magento\Webpos\Test\TestStep;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestStep\TestStepInterface;

/**
 * Class CreateNewConfigurableProductsStep
 * @package Magento\Webpos\Test\TestStep
 */
class CreateNewConfigurableProductsStep implements TestStepInterface
{
    /**
     * @var FixtureFactory
     */
    protected $fixtureFactory;

    /**
     * @var
     */
    protected $products;

    /**
     * CreateNewProductsStep constructor.
     * @param FixtureFactory $fixtureFactory
     * @param $products
     */
    public function __construct(
        FixtureFactory $fixtureFactory,
        $products
    )
    {
        $this->fixtureFactory = $fixtureFactory;
        $this->products = $products;
    }

    /**
     * @return mixed
     */
    public function run()
    {
        // Create products
        foreach ($this->products as $key => $item) {
            $this->products[$key]['product'] = $this->fixtureFactory->createByCode('configurableProduct', ['dataset' => $item['product']]);
            $this->products[$key]['product']->persist();
        }

        return $this->products;
    }
}