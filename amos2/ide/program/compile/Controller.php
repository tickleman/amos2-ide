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

	//----------------------------------------------------------------------------- prepareAndCompile
	/**
	 * @param $program Program
	 * @param $form    array
	 * @return Compile
	 */
	public function prepareAndCompile(Program $program, $form)
	{
		if (!$program->author->login) $program->author->login = $_SERVER['REMOTE_ADDR'];
		if (!$program->name) $program->name = 'new';
		if (isset($form['code'])) {
			(new Object_Builder_Array())->build($form, $program);
		}
		$compile = new Compile($program);
		$compile->compile();
		return $compile;
	}

	//------------------------------------------------------------------------------------------- run
	/**
	 * @param $parameters Parameters
	 * @param $form       array
	 * @param $files      array[]
	 * @return mixed
	 */
	public function run(Parameters $parameters, array $form, array $files)
	{
		$program = $parameters->getMainObject(Program::class);
		$compile = $this->prepareAndCompile($program, $form);
		$parameters->set('compile', $compile);
		$parameters = $parameters->getObjects();
		return View::run($parameters, $form, $files, get_class($program), static::FEATURE);
	}

}
