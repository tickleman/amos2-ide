<?php
namespace Amos2\Ide\Program\Output;

use Amos2\Ide\Program;
use ITRocks\Framework\Component\Button;
use ITRocks\Framework\Controller\Feature;
use ITRocks\Framework\Feature\Output;
use ITRocks\Framework\Setting;
use ITRocks\Framework\View;

/**
 * Program output controller
 */
class Controller extends Output\Controller
{

	//----------------------------------------------------------------------------- getGeneralButtons
	/**
	 * @param $object     Program
	 * @param $parameters array
	 * @param $settings   Setting\Custom\Set|null
	 * @return Button[]
	 */
	public function getGeneralButtons($object, array $parameters, Setting\Custom\Set $settings = null)
	{
		$buttons = parent::getGeneralButtons($object, $parameters, $settings);
		$buttons[Feature::F_DUPLICATE]->caption = 'Fork';

		$buttons = array_merge(
			[
				'compile' => new Button(
					'Compile', View::link($object, 'compile'), 'compile', ['.submit', '#responses']
				),
				'run' => new Button(
					'Run', View::link($object, 'run'), 'run', ['.submit', '#responses']
				)
			],
			$buttons
		);

		return $buttons;
	}

}
