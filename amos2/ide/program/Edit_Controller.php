<?php
namespace Amos2\Ide\Program;

use Amos2\Ide\Program;
use ITRocks\Framework\Component\Button;
use ITRocks\Framework\Controller\Feature;
use ITRocks\Framework\Feature\Edit\Controller;
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

}
