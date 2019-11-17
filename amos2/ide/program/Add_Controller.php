<?php
namespace Amos2\Ide\Program;

use Amos2\Ide\Program;
use ITRocks\Framework\Component\Button;
use ITRocks\Framework\Feature\Add\Controller;
use ITRocks\Framework\Setting;

/**
 * Program add controller
 */
class Add_Controller extends Controller
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
		return array_merge((new Compile_Run)->buttons($program), $buttons);
	}

}
