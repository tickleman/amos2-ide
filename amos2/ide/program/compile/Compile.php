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

	//---------------------------------------------------------------------------------- compilerExec
	/**
	 * @example /home/amos2/compiler/0.7/amosc-linux-x64
	 * @example wine /home/amos2/compiler/0.9.2.6/aoz-x86.exe
	 * @return string
	 */
	protected function compilerExec()
	{
		$path = $this->compilerPath();
		$exec = $path . '/aoz-linux-x64';
		if (!file_exists($exec)) {
			$exec = $path . '/amosc-linux-x64';
		}
		if (!file_exists($exec)) {
			$exec = "wine $path/aoz-x86.exe";
		}
		return $exec;
	}

	//---------------------------------------------------------------------------------- compilerPath
	/**
	 * @return string
	 */
	protected function compilerPath()
	{
		return Compiler::get()->path . SL . $this->program->version;
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
		mkdir("$path/resources/images",  0700, true);
		mkdir("$path/resources/sprites", 0700, true);
		// main program
		$ext = ($this->program->version > '0.9') ? 'aoz' : 'amos';
		file_put_contents("$path/main.$ext", $this->program->code);
		// manifest
		$manifest = $this->compilerPath() . '/templates/empty_application/manifest.hjson';
		if (!file_exists($manifest)) {
			// 0.7
			$manifest = $this->compilerPath() . '/demos/amosball/manifest.hjson';
		}
		if ($this->program->version < '0.9.3.2') {
			copy($manifest, "$path/manifest.hjson");
		}
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
					$directory = ($this->program->version < '0.9')
						? 'sprites'
						: 'images';
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
			if (
				beginsWith($output, 'All tasks successful')
				|| beginsWith($output, 'Compilation successful')
			) {
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
		$command = $this->compilerExec() . SP . $input;
		$cwd     = getcwd();
		chdir($this->compilerPath());
		clearstatcache();
		if (strpos($command, 'wine') === 0) {
			@unlink("$input/output");
			$path = Compiler::get()->path;
			$id   = uniqid();
			file_put_contents("$path/in/$id", join("\n", [$this->program->version, $input]));
			$wait = 100;
			while (--$wait && !file_exists("$path/out/$id")) {
				usleep(100000);
				clearstatcache();
			}
			if (!file_exists("$path/out/$id")) {
				$output = ['Error : winecompile call timeout'];
			}
			else {
				$wait = 100;
				while (--$wait && !file_exists("$input/output")) {
					usleep(100000);
					clearstatcache();
				}
				$output = file_exists("$input/output")
					? file("$input/output")
					: ['Error : winecompile call timeout or no output'];
				unlink("$path/out/$id");
			}
		}
		else {
			exec("$command 2>&1", $output);
		}
		chdir($cwd);
		$this->raw_output = array_merge($this->raw_output, $output);
	}

}
