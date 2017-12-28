<?php
/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 12/28/2017
 * Time: 11:16 AM
 */

namespace Magento\PurchaseOrderSuccess\Test\Handler\ReturnOrder;

use Magento\Mtf\Fixture\FixtureInterface;
use Magento\Mtf\Handler\Curl as AbstractCurl;
use Magento\Mtf\Util\Protocol\CurlInterface;
use Magento\Mtf\Util\Protocol\CurlTransport;
use Magento\Mtf\Util\Protocol\CurlTransport\BackendDecorator;

class Curl extends AbstractCurl implements ReturnOrderInterface
{

}