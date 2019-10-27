<?php
namespace Amos2\Ide;

use Amos2\Ide;
use ITRocks\Framework;
use ITRocks\Framework\Configuration;
use ITRocks\Framework\Dao\File;
use ITRocks\Framework\Email\Sender\Smtp;
use ITRocks\Framework\Plugin\Priority;
use ITRocks\Framework\User\Access_Control;

global $loc, $pwd;
require __DIR__ . '/../../itrocks/framework/config.php';

$config['Amos2/Ide'] = [
	Configuration::APP         => Application::class,
	Configuration::ENVIRONMENT => $loc[Configuration::ENVIRONMENT],
	Configuration::EXTENDS_APP => 'ITRocks/Framework',

	//---------------------------------------------------------------------------------- CORE plugins
	Priority::CORE => [
		Framework\Builder::class => include(__DIR__ . SL . 'builder.php'),
	],

	//------------------------------------------------------------------------ LOWER priority plugins
	Priority::LOWER => [
		// lower than Maintainer to log all sql errors
		Framework\Dao\Mysql\File_Logger::class => ['path' => $loc[File\Link::class]['path'] . '/logs']
	],

	//----------------------------------------------------------------------- NORMAL priority plugins
	Priority::NORMAL => [
		Framework\Dao::class => [
			Framework\Dao::LINKS_LIST => ['files' => $loc[File\Link::class]]
		],
		Framework\Email\Archive::class,
		Framework\Email\Sender\Smtp::class => array_merge(
			$loc[Smtp::class], [Smtp::PASSWORD => $pwd[Smtp::class]]
		),
		Framework\Logger::class,
		Framework\User\Access_Control::class => [
			Access_Control::EXCEPTIONS => [
				'/ITRocks/Framework/User/register'
			]
		],
		Framework\User\Group\Admin_Plugin::class,
		Framework\Component\Menu::class => include(__DIR__ . SL . 'menu.php'),
		Framework\Feature\Validate\Validator::class,
		Framework\User\Access_Control\Data::class,

		Ide\Compiler::class => $loc[Ide\Compiler::class],
		Ide\User\Hide_Menu::class
	],

	//----------------------------------------------------------------------- HIGHER priority plugins
	Priority::HIGHER => [
		Framework\Dao\Cache::class,
		Framework\View\Logger::class => ['path' => $loc[File\Link::class]['path'] . '/logs']
	]

];
