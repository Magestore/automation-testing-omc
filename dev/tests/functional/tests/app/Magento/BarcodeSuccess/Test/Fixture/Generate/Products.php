<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 25/12/2017
 * Time: 13:43
 */
namespace Magento\BarcodeSuccess\Test\Fixture\Generate;

use Magento\Mtf\Fixture\DataSource;
use Magento\Mtf\Fixture\FixtureFactory;

class Products extends DataSource
{
    protected $productData = [];
    public function __construct(
        FixtureFactory $fixtureFactory,
        array $params,
        array $data = []
    ) {
        $this->params = $params;
        if (isset($data['dataset']) && $data['dataset'] !== '-') {
            $datasets = explode(',', $data['dataset']);
            foreach ($datasets as $dataset) {
                $product = $fixtureFactory->createByCode(
                    'catalogProductSimple',
                    ['dataset' => $dataset,]
                );
                $product->persist();
                $this->productData[] = $product->getData();
                $this->data[] = [
                    'sku' => $product->getSku()
                ];
            }
        }else {
            $this->data[] = null;
        }
    }
    public function getDataProducts() {
        return $this->productData;
    }
}