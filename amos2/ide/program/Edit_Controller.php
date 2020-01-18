<?php
namespace Amos2\Ide\Program;

use Amos2\Ide\Compiler\Versions;
use Amos2\Ide\Program;
use ITRocks\Framework\Component\Button;
use ITRocks\Framework\Controller\Feature;
use ITRocks\Framework\Controller\Parameters;
use ITRocks\Framework\Feature\Edit\Controller;
use ITRocks\Framework\Feature\Validate\Property\Values_Annotation;
use ITRocks\Framework\Reflection\Reflection_Property;
use ITRocks\Framework\Setting;
use ITRocks\Framework\View;

/**
 * Program edit controller
 */
class Edit_Controller extends Controller
{

	//----------------------------------------------------------------------------- getGeneralButtons
	/**
	 * @param $program    Program
	 * @param $parameters array
	 * @param $settings Setting\Custom\Set|null
	 * @return Button[]
	 */
	public function getGeneralButtons($program, array $parameters, Setting\Custom\Set $settings = null)
	{
		$buttons = parent::getGeneralButtons($program, $parameters, $settings);
		$buttons[Feature::F_CLOSE]->link = View::link($program);
		return array_merge((new Compile_Run)->buttons($program), $buttons);
	}

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
		$versions = (new Versions)->list();
		Values_Annotation::of(new Reflection_Property(Program::class, 'version'))->value = $versions;
		return parent::run($parameters, $form, $files, $class_name);
	}

}
