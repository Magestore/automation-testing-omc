<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 01/11/2017
 * Time: 13:34
 */

namespace Magento\Webpos\Test\Handler\CustomerComplain;

use Magento\Mtf\Config\DataInterface;
use Magento\Mtf\Fixture\FixtureInterface;
use Magento\Mtf\Handler\Webapi as AbstractWebapi;
use Magento\Mtf\System\Event\EventManagerInterface;
use Magento\Mtf\Util\Protocol\CurlTransport\WebapiDecorator;
use Magento\Webpos\Test\Fixture\CustomerComplain;

class Webapi extends AbstractWebapi implements CustomerComplainInterface
{
	public function __construct(
		DataInterface $configuration,
		EventManagerInterface $eventManager,
		WebapiDecorator $webapiTransport
	) {
		parent::__construct($configuration, $eventManager, $webapiTransport);
	}
	/**
	 *
	 *
	 * @param FixtureInterface $fixture
	 * @return array
	 * @throws \Exception
	 */
	public function persist(FixtureInterface $fixture = null)
	{
		$data = $this->prepareData($fixture);
		$url = $_ENV['app_frontend_url'] . 'rest/V1/webpos/customers/complain';
		$this->webapiTransport->write($url, $data);
		$response = json_decode($this->webapiTransport->read(), true);
		$this->webapiTransport->close();

		if (!$response) {
			$this->eventManager->dispatchEvent(['webapi_failed'], [$response]);
			throw new \Exception('Customer Complain creation by Web API handler was not successful!');
		}
//		return ['complain_id' => $response[0]['complain_id']];
	}

	/**
	 * @param CustomerComplain $fixture
	 * @return array
	 */
	protected function prepareData(CustomerComplain $fixture)
	{
		$data = $fixture->getData();

		return ['complain' => $data];
	}
}