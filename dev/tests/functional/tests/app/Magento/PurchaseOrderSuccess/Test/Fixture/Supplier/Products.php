<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/25/2017
 * Time: 4:20 PM
 */

namespace Magento\PurchaseOrderSuccess\Test\Fixture\Supplier;

use Magento\Mtf\Fixture\DataSource;
use Magento\Mtf\Fixture\FixtureFactory;

class Products extends DataSource
{
    /**
     * Products fixture.
     *
     * @var array
     */
    protected $products = [];

    /**
     * @param FixtureFactory $fixtureFactory
     * @param array $params
     * @param array $data [optional]
     */
    public function __construct(
        FixtureFactory $fixtureFactory,
        array $params,
        array $data = []
    ) {
        $this->params = $params;

        if (isset($data['dataset'])) {
            $productsList = array_map('trim', explode(',', $data['dataset']));
            foreach ($productsList as $productData) {
                list($fixtureCode, $dataset) = explode('::', $productData);
                $this->products[] = $fixtureFactory->createByCode($fixtureCode, ['dataset' => $dataset]);
            }
        }
        if (isset($data['products'])) {
            foreach ($data['products'] as $product) {
                $this->products[] = $product;
            }
        }

        foreach ($this->products as $product) {
            if (!$product->hasData('id')) {
                $product->persist();
            }

            $this->data[] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'sku' => $product->getSku(),
            ];
        }
        if (isset($data['data'])) {
            $this->data = array_replace_recursive($this->data, $data['data']);
        }
    }

    /**
     * Return related products.
     *
     * @return array
     */
    public function getProducts()
    {
        return $this->products;
    }
}