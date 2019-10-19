<?php
namespace Amos2\Ide;

use ITRocks\Framework\Dao;
use ITRocks\Framework\Dao\File;
use ITRocks\Framework\Plugin\Configurable;
use ITRocks\Framework\Plugin\Has_Get;

/**
 * AMOS 2 compiler
 */
class Compiler implements Configurable
{
	use Has_Get;

	//-------------------------------------------------------------- Configuration property constants
	const OUTPUT = 'output';
	const PATH   = 'path';
	const RUN    = 'run';

	//--------------------------------------------------------------------------------------- $output
	/**
	 * Path to AMOS 2 output files (compiled programs)
	 *
	 * @var string
	 */
	public $output;

	//----------------------------------------------------------------------------------------- $path
	/**
	 * Path to AMOS 2 compiler
	 *
	 * @var string
	 */
	public $path;

	//------------------------------------------------------------------------------------------ $run
	/**
	 * Base path to run programs
	 *
	 * @var string
	 */
	public $run;

	//----------------------------------------------------------------------------------- __construct
	/**
	 * @param $configuration array
	 */
	public function __construct($configuration = null)
	{
		if (!isset($configuration)) {
			return;
		}
		if (!is_array($configuration)) {
			$configuration = [static::PATH => $configuration];
		}
		foreach ($configuration as $property_name => $value) {
			$this->$property_name = $value;
		}
	}

	//----------------------------------------------------------------------------------------- input
	/**
	 * Temporary input files path
	 *
	 * @return string
	 */
	public function input()
	{
		/** @var $file File\Link */
		$file = Dao::get('files');
		$path = $file->getPath() . 'input';
		if (!is_dir($path)) {
			mkdir($path, 0700, true);
		}
		return $path;
	}

}
