<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 09/03/2018
 * Time: 08:32
 */

namespace Magento\Webpos\Test\TestStep;


use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\ObjectManager;
use Magento\Mtf\TestStep\TestStepInterface;

class CreateNewProductByCurlStep implements TestStepInterface
{
	/**
	 * @var FixtureFactory
	 */
	protected $fixtureFactory;

	/**
	 * @var ObjectManager
	 */
	protected $objectManager;

	protected $productData;

	/**
	 * CreateNewProductsStep constructor.
	 * @param FixtureFactory $fixtureFactory
	 * @param $productData
	 * Ex: catalogProductSimple::default
	 */
	public function __construct(
		FixtureFactory $fixtureFactory,
		ObjectManager $objectManager,
		$productData
	)
	{
		$this->fixtureFactory = $fixtureFactory;
		$this->objectManager = $objectManager;
		$this->productData = $productData;
	}

	/**
	 * @return mixed
	 */
	public function run()
	{
		$this->productData = explode('::', $this->productData);
		$product = $this->fixtureFactory->createByCode($this->productData[0], ['dataset' => $this->productData[1]]);
		$id = $this->objectManager->create('Magento\Catalog\Test\Handler\CatalogProductSimple\Curl')->persist($product);
		$data = array_merge($product->getData(), $id);

		return $this->fixtureFactory->createByCode($this->productData[0], ['data' => $data]);
	}
}