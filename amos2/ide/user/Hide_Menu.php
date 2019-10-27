<?php
namespace Amos2\Ide\User;

use ITRocks\Framework\Component\Menu;
use ITRocks\Framework\Dao;
use ITRocks\Framework\Plugin\Register;
use ITRocks\Framework\Plugin\Registerable;
use ITRocks\Framework\User;

/**
 * Hide user menu plugin
 */
class Hide_Menu implements Registerable
{

	//------------------------------------------------------------------------------- menuCheckAccess
	/**
	 * @param $block_key string
	 * @return boolean
	 */
	public function menuCheckAccess($block_key)
	{
		$user = User::current();
		return (($block_key === 'User account') && Dao::getObjectIdentifier($user))
			? false
			: null;
	}

	//-------------------------------------------------------------------------------------- register
	/**
	 * Registration code for the plugin
	 *
	 * @param $register Register
	 */
	public function register(Register $register)
	{
		$register->aop->beforeMethod([Menu::class, 'constructBlock'], [$this, 'menuCheckAccess']);
	}

}
