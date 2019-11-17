<?php
namespace Amos2\Ide\Program;

use Amos2\Ide\Program;
use ITRocks\Framework\Dao\File;
use ITRocks\Framework\Mapper\Component;

/**
 * A resource for a program
 *
 * @override comment @multiline false
 */
class Resource
{
	use Component;

	//----------------------------------------------------------------------------------------- $file
	/**
	 * @link Object
	 * @var File
	 */
	public $file;

	//----------------------------------------------------------------------------------------- $keep
	/**
	 * TODO This is a patch to keep files when writing a form with unchanged files (framework bug)
	 *
	 * @store false
	 * @user hidden
	 * @var boolean
	 */
	public $keep;

	//-------------------------------------------------------------------------------------- $program
	/**
	 * @composite
	 * @link Object
	 * @var Program
	 */
	public $program;

	//----------------------------------------------------------------------------------- __construct
	public function __construct()
	{
		// TODO This is a patch to keep files when writing a form with unchanged files (framework bug)
		$this->keep = ($this->file ? true : false);
	}

}
