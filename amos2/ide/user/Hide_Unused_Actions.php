<?php
namespace Amos2\Ide\User;

use ITRocks\Framework\Component\Button;
use ITRocks\Framework\Controller\Feature;
use ITRocks\Framework\Feature\List_;
use ITRocks\Framework\Feature\Output;
use ITRocks\Framework\Plugin\Register;
use ITRocks\Framework\Plugin\Registerable;

/**
 * Hide print, import and export buttons
 * Delete should be hidden too : it is dangerous
 */
class Hide_Unused_Actions implements Registerable
{

	//--------------------------------------------------------------------------- removeUnusedButtons
	/**
	 * @param $result Button[]
	 */
	public function removeUnusedButtons(&$result)
	{
		unset($result[Feature::F_EXPORT]);
		unset($result[Feature::F_IMPORT]);
		unset($result[Feature::F_PRINT]);
	}

	/**
	 * @param $register Register
	 */
	public function register(Register $register)
	{
		$aop = $register->aop;
		$aop->afterMethod(
			[List_\Controller::class, 'getGeneralButtons'], [$this, 'removeUnusedButtons']
		);
		$aop->afterMethod(
			[List_\Controller::class, 'getSelectionButtons'], [$this, 'removeUnusedButtons']
		);
		$aop->afterMethod(
			[Output\Controller::class, 'getGeneralButtons'], [$this, 'removeUnusedButtons']
		);
	}

}
