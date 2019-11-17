<?php
namespace Amos2\Ide\Program;

use Amos2\Ide\Program;
use ITRocks\Framework\Component\Button;
use ITRocks\Framework\View;

/**
 * Compile / run components
 */
class Compile_Run
{

	//--------------------------------------------------------------------------------------- buttons
	/**
	 * @param $program Program
	 * @return Button[]
	 */
	public function buttons(Program $program)
	{
		return [
			'compile' => new Button(
				'Compile', View::link($program, 'compile'), 'compile', ['.submit', '#responses']
			),
			'run' => new Button(
				'Run', View::link($program, 'run'), 'run', ['.submit', '#responses']
			)
		];
	}

}
