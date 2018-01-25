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

class CreateNewProductsStep implements TestStepInterface
{
	/**
	 * @var FixtureFactory
	 */
	protected $fixtureFactory;

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
			if (isset($item['fixtureName'])) {
				$fixtureName = $item['fixtureName'];
			} else {
				$fixtureName = "catalogProductSimple";
			}
			$this->products[$key]['product'] = $this->fixtureFactory->createByCode($fixtureName, ['dataset' => $item['product']]);
			$this->products[$key]['product']->persist();
		}

		return $this->products;
	}
}