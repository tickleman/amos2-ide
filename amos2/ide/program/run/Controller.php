<?php
namespace Amos2\Ide\Program\Run;

use Amos2\Ide\Compiler;
use Amos2\Ide\Program;
use Amos2\Ide\Program\Compile;
use ITRocks\Framework\Controller\Parameters;
use ITRocks\Framework\View;

/**
 * Program run controller
 */
class Controller extends Compile\Controller
{

	//--------------------------------------------------------------------------------------- FEATURE
	const FEATURE = 'run';

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
		$parameters->set('run_link', Compiler::get()->run . SL . $program->dirName());
		$parameters = $parameters->getObjects();
		return View::run($parameters, $form, $files, get_class($program), static::FEATURE);

	}

}
