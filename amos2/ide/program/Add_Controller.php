<?php
namespace Amos2\Ide\Program;

use Amos2\Ide\Program;
use ITRocks\Framework\Controller\Parameters;
use ITRocks\Framework\Feature\Add\Controller;
use ITRocks\Framework\Reflection\Annotation\Property\User_Annotation;
use ITRocks\Framework\Reflection\Reflection_Property;

/**
 * Program add controller
 */
class Add_Controller extends Controller
{

	//------------------------------------------------------------------------------------------- run
	/**
	 * @noinspection PhpDocMissingThrowsInspection
	 * @param $parameters Parameters
	 * @param $form       array
	 * @param $files      array[]
	 * @param $class_name string
	 * @return mixed
	 */
	public function run(Parameters $parameters, array $form, array $files, $class_name)
	{
		/** @noinspection PhpUnhandledExceptionInspection */
		User_Annotation::of(new Reflection_Property($parameters->getMainObject(Program::class), 'code'))
			->add('invisible');
		return parent::run($parameters, $form, $files, $class_name);
	}

}
