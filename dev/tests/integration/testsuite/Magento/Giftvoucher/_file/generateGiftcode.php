<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 29/12/2017
 * Time: 16:28
 */

$objectManager = \Magento\TestFramework\Helper\Bootstrap::getObjectManager();
/**
 * @var \Magestore\Giftvoucher\Model\Giftvoucher $giftVoucher
 */
$giftCodePattern = $objectManager->create(\Magestore\Giftvoucher\Model\Giftvoucher::class);
$pattern = mt_rand(10000000,100000000);
$giftCodePattern->setPattern($pattern)
    ->setTemplateName('[AN.6]')
    ->setBalance(15)
    ->setAmount(150)
    ->setExpiredAt('2018-12-28 00:00:00')
    ->setStoreId(0);

/**
 * @var \Magestore\Giftvoucher\Model\ResourceModel\Giftvoucher $resourceGiftvoucher
 */
$resourceGiftvoucher = $objectManager->create(\Magestore\Giftvoucher\Model\ResourceModel\Giftvoucher::class);
$resourceGiftvoucher->save($giftCodePattern);