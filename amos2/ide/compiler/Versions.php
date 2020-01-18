<?php
namespace Amos2\Ide\Compiler;

use Amos2\Ide\Compiler;

/**
 * Compiler versions
 */
class Versions
{

	//--------------------------------------------------------------------------------------- default
	/**
	 * @return string
	 */
	public static function default()
	{
		$versions = (new Versions)->list();
		return end($versions);
	}

	//------------------------------------------------------------------------------------------ list
	/**
	 * @return string[]
	 */
	public function list()
	{
		if (!Compiler::get(false) || !Compiler::get()->path || !file_exists(Compiler::get()->path)) {
			return ['0.7'];
		}
		$versions = [];
		foreach (scandir(Compiler::get()->path) as $version) {
			if (is_numeric(substr($version, 0, 1))) {
				$versions[] = $version;
			}
		}
		return $versions;
	}

}
