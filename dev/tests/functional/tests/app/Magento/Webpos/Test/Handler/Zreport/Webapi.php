<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 11/09/2017
 * Time: 17:02
 */

namespace Magento\Webpos\Test\Handler\Zreport;

use Magento\Mtf\Config\DataInterface;
use Magento\Mtf\Fixture\FixtureInterface;
use Magento\Mtf\Handler\Webapi as AbstractWebapi;
use Magento\Mtf\System\Event\EventManagerInterface;
use Magento\Mtf\Util\Protocol\CurlTransport\WebapiDecorator;
use Magento\Webpos\Test\Fixture\Shift;

class Webapi extends AbstractWebapi implements ZreportInterface
{

	public function __construct(
		DataInterface $configuration,
		EventManagerInterface $eventManager,
		WebapiDecorator $webapiTransport
//		Curl $taxRuleCurl
	) {
		parent::__construct($configuration, $eventManager, $webapiTransport);
//		$this->taxRuleCurl = $taxRuleCurl;
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
		$url = $_ENV['app_frontend_url'] . 'rest/V1/webpos/shifts/save';
		$this->webapiTransport->write($url, $data);
		$response = json_decode($this->webapiTransport->read(), true);
		$this->webapiTransport->close();

		if (empty($response[0]['entity_id'])) {
			$this->eventManager->dispatchEvent(['webapi_failed'], [$response]);
			throw new \Exception('Zreport creation by Web API handler was not successful!');
		}
		return ['entity_id' => $response[0]['entity_id']];
	}

	/**
	 * @param Shift $fixture
	 * @return array
	 */
	protected function prepareData(Shift $fixture)
	{
		$data = $fixture->getData();
		if (isset($data['opened_at'])) {
			$data['opened_at'] = date('Y-m-d H:i:s A', strtotime($data['opened_at']));
		}
		if (isset($data['closed_at'])) {
			$data['closed_at'] = date('Y-m-d H:i:s A', strtotime($data['closed_at']));
		}
		return ['shift' => $data];
	}
}
