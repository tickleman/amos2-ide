<?php
namespace Amos2\Ide\Program;

use Amos2\Ide\Compiler\Versions;
use Amos2\Ide\Program;
use ITRocks\Framework\Component\Button;
use ITRocks\Framework\Feature\Add\Controller;
use ITRocks\Framework\Feature\Validate\Property\Values_Annotation;
use ITRocks\Framework\Reflection\Reflection_Property;
use ITRocks\Framework\Setting;

/**
 * Program add controller
 */
class Add_Controller extends Controller
{

	//----------------------------------------------------------------------------- getGeneralButtons
	/**
	 * @noinspection PhpDocMissingThrowsInspection
	 * @param $program    Program
	 * @param $parameters array
	 * @param $settings Setting\Custom\Set|null
	 * @return Button[]
	 */
	public function getGeneralButtons($program, array $parameters, Setting\Custom\Set $settings = null)
	{
		$versions = (new Versions)->list();
		Values_Annotation::of(new Reflection_Property(Program::class, 'version'))->value = $versions;
		$buttons = parent::getGeneralButtons($program, $parameters, $settings);
		return array_merge((new Compile_Run)->buttons($program), $buttons);
	}

}
