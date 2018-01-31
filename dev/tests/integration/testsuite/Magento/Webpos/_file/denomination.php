<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 25/12/2017
 * Time: 15:03
 */

$objectManager = \Magento\TestFramework\Helper\Bootstrap::getObjectManager();
/**
 * @var \Magestore\Webpos\Model\Denomination\Denomination $denomination
 */
$denomination = $objectManager->create(\Magestore\Webpos\Model\Denomination\Denomination::class);
$denomination->load(1);
$denomination->setDenominationName('100k')
	->setDenominationValue(100000)
	->setSortOrder(1);


/**
 * @var \Magestore\Webpos\Model\ResourceModel\Denomination\Denomination $resourceDenomination
 */
$resourceDenomination = $objectManager->create(\Magestore\Webpos\Model\ResourceModel\Denomination\Denomination::class);
$resourceDenomination->save($denomination);
