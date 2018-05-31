<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 03/01/2018
 * Time: 14:17
 */

namespace Magento\Webpos\Test\TestStep;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestStep\TestStepInterface;

/**
 * Class CreateNewProductsStep
 * @package Magento\Webpos\Test\TestStep
 */
class CreateNewProductsStep implements TestStepInterface
{
    /**
     * @var FixtureFactory $fixtureFactory
     */
    protected $fixtureFactory;

    protected $products;

    protected $childProducts;

    protected $productType;

    /**
     * CreateNewProductsStep constructor.
     * @param FixtureFactory $fixtureFactory
     * @param $products
     */
    public function __construct(
        FixtureFactory $fixtureFactory,
        $products,
        $productType = 'simpleProduct'
    )
    {
        $this->fixtureFactory = $fixtureFactory;
        $this->products = $products;
        $this->productType = $productType;
    }

    /**
     * @return mixed
     */
    public function run()
    {
        // Create product
        foreach ($this->products as $key => $item) {
            if (isset($item['fixtureName'])) {
                $fixtureName = $item['fixtureName'];
            } else {
                $fixtureName = "catalogProductSimple";
            }
            $this->products[$key]['product'] = $this->fixtureFactory->createByCode($fixtureName, ['dataset' => $item['product']]);
            $this->products[$key]['product']->persist();
            $this->childProducts = null;
            if ($this->productType == 'bundleProduct') {
                $this->childProducts = $this->products[$key]['product']->getDataFieldConfig('bundle_selections')['source']->getProducts();
            }
        }

        return $this->products;
    }

    public function getChildProducts()
    {
        return $this->childProducts;
    }
}