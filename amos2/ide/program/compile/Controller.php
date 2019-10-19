<?php
namespace Amos2\Ide\Program\Compile;

use Amos2\Ide\Program;
use Amos2\Ide\Program\Compile;
use ITRocks\Framework\Controller\Feature_Controller;
use ITRocks\Framework\Controller\Parameters;
use ITRocks\Framework\Mapper\Object_Builder_Array;
use ITRocks\Framework\View;

/**
 * Program compile controller
 */
class Controller implements Feature_Controller
{

	//--------------------------------------------------------------------------------------- FEATURE
	const FEATURE = 'compile';

	//------------------------------------------------------------------------------------------- run
	/**
	 * @param $parameters Parameters
	 * @param $form       array
	 * @param $files      array[]
	 * @return mixed
	 */
	public function run(Parameters $parameters, array $form, array $files)
	{
		/** @var $program Program */
		$program = $parameters->getMainObject(Program::class);
		if (isset($form['code'])) {
			(new Object_Builder_Array())->build($form, $program);
		}
		$compile = new Compile($program);
		$compile->compile();

		$parameters = $parameters->getObjects();
		$parameters['compile'] = $compile;
		return View::run($parameters, $form, $files, get_class($program), static::FEATURE);
	}

}
