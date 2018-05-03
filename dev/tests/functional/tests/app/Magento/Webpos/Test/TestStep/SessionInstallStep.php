<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 22/11/2017
 * Time: 10:22
 */
namespace  Magento\Webpos\Test\TestStep;


/**
 * Class LoginWebposStep
 * @package Magento\Webpos\Test\TestStep
 */
class SessionInstallStep extends LoginWebposStep
{


	public function run()
	{
		$staff = parent::run();
        /**
         *  wait sync complete
         */
        while (
            ( rtrim($this->webposIndex->getSessionInstall()->getPercent()->getText(),"%") * 1 ) < 95
        ) {

        }

        sleep(4);
        return $staff;
    }
}