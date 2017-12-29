<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 22/12/2017
 * Time: 16:24
 */


$objectManager = \Magento\TestFramework\Helper\Bootstrap::getObjectManager();
/**
 * @var \Magestore\Webpos\Model\Shift\Shift $shift
 */
$shift = $objectManager->create(\Magestore\Webpos\Model\Shift\Shift::class);
$shift->load(1);
$shift->setShiftId('shift_custom_1')
	->setStaffId(1)
	->setStatus(1)
	->setBalance(10000)
	->setBaseBalance(10000)
	->setBaseCashAdded(10000)
	->setBaseCashLeft(1000)
	->setBaseCashRemoved(0)
	->setBaseCashSale(0)
	->setBaseClosedAmount(0)
	->setBaseCurrencyCode('USD')
	->setBaseFloatAmount(10000)
	->setBaseTotalSales(0)
	->setCashAdded(10000)
	->setCashLeft(0)
	->setCashRemoved(0)
	->setCashSale(0)
	->setClosedAmount(0)
	->setClosedAt('2016-12-28 00:00:00')
	->setClosedNote('Close Note 1')
	->setFloatAmount(10000)
	->setLocationId(1)
	->setOpenedAt('2016-12-21 00:00:00')
	->setOpenedNote('Open Note 1')
	->setShiftCurrencyCode('USD');
$shift->setTotalSales(0);

/**
 * @var \Magestore\Webpos\Model\ResourceModel\Shift\Shift $resourceShift
 */
$resourceShift = $objectManager->create(\Magestore\Webpos\Model\ResourceModel\Shift\Shift::class);
$resourceShift->save($shift);