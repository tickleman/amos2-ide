<?php
namespace Amos2\Ide\Program;

use Amos2\Ide\Compiler;
use Amos2\Ide\Program;

/**
 * Compile a program
 */
class Compile
{

	//--------------------------------------------------------------------------------------- $errors
	/**
	 * @var string[]
	 */
	public $errors = [];

	//-------------------------------------------------------------------------------------- $program
	/**
	 * @var Program
	 */
	public $program;

	//----------------------------------------------------------------------------------- $raw_output
	/**
	 * @var string[]
	 */
	public $raw_output = [];

	//--------------------------------------------------------------------------------------- $report
	/**
	 * @var string[]
	 */
	public $report = [];

	//----------------------------------------------------------------------------------- __construct
	/**
	 * @param $program Program
	 */
	public function __construct(Program $program = null)
	{
		if (isset($program)) {
			$this->program = $program;
		}
	}

	//--------------------------------------------------------------------------------------- compile
	public function compile()
	{
		$input = $this->generateInput();
		$this->runCompiler($input);
		$this->rawOutputToReport();
		$this->publish($input);
	}

	//--------------------------------------------------------------------------------- generateInput
	/**
	 * @return string
	 */
	protected function generateInput()
	{
		$compiler = Compiler::get();
		// input directory
		$dir      = $this->program->dirName();
		$path     = $compiler->input() . SL . $dir;
		if (is_dir($path)) {
			deleteDirectory($path);
		}
		mkdir("$path/resources/fonts",   0700, true);
		mkdir("$path/resources/sprites", 0700, true);
		// main program
		file_put_contents("$path/main.amos", $this->program->code);
		// manifest
		copy($compiler->path . '/demos/amosball/manifest.hjson', "$path/manifest.hjson");
		// resources
		foreach ($this->program->resources as $resource) {
			if (!$resource->file) {
				continue;
			}
			$content = $resource->file->content;
			$name    = $resource->file->name;
			switch (rLastParse($name, DOT)) {
				case 'font':
				case 'googlefont':
					$directory = 'fonts';
					break;
				case 'jpg':
				case 'png':
					$directory = 'sprites';
					break;
				default:
					$directory = null;
			}
			if (!$directory) {
				continue;
			}
			file_put_contents("$path/resources/$directory/$name", $content);
		}

		return $path;
	}

	//--------------------------------------------------------------------------------------- publish
	/**
	 * @param $input string
	 */
	protected function publish($input)
	{
		$compiler = Compiler::get();
		$output   = $compiler->output . '/' . $this->program->dirName();
		if (!is_dir($output)) {
			mkdir($output, 0700, true);
		}
		exec("rsync -aPq --delete $input/html/ $output/ 2>&1", $output);
		$this->raw_output = array_merge($this->raw_output, $output);
	}

	//----------------------------------------------------------------------------- rawOutputToReport
	protected function rawOutputToReport()
	{
		$this->report = [];
		foreach ($this->raw_output as $output) {
			if (beginsWith($output, 'Compilation successful')) {
				$this->report[] = $output;
			}
			if (strpos($output, 'error')) {
				$this->errors[] = $output;
			}
		}
		if ($this->report) {
			$this->errors = [];
			return;
		}
		$this->report = array_merge(['Error during compilation'], $this->raw_output);
	}

	//----------------------------------------------------------------------------------- runCompiler
	/**
	 * @param $input string
	 */
	protected function runCompiler($input)
	{
		$compiler = Compiler::get();
		$command  = $compiler->path . '/amosc-linux-x64' . SP . $input;
		$cwd      = getcwd();
		chdir($compiler->path);
		exec("$command 2>&1", $output);
		chdir($cwd);
		$this->raw_output = array_merge($this->raw_output, $output);
	}

}
