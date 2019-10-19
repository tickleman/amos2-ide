<?php
namespace Amos2\Ide;

use ITRocks\Framework;
use ITRocks\Framework\Configuration;
use ITRocks\Framework\Dao\File;
use ITRocks\Framework\Email\Sender;
use ITRocks\Framework\Plugin\Priority;

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
		Framework\Dao\Mysql\File_Logger::class => [
			'path' => $loc[File\Link::class]['path'] . '/logs',
		]
	],

	//----------------------------------------------------------------------- NORMAL priority plugins
	Priority::NORMAL => [
		Framework\Dao::class => [
			Framework\Dao::LINKS_LIST => [
				'files' => $loc[File\Link::class]
			]
		],
		Framework\Email\Archive::class,
		Framework\Email\Sender::class => array_merge(
			$loc[Sender::class],
			[Sender::PASSWORD => $pwd[Sender::class]]
		),
		Framework\Logger::class,
		Framework\User\Access_Control::class,
		Framework\User\Group\Admin_Plugin::class,
		Framework\Component\Menu::class => include(__DIR__ . SL . 'menu.php'),
		Framework\Feature\Validate\Validator::class
	],

	//----------------------------------------------------------------------- HIGHER priority plugins
	Priority::HIGHER => [
		Framework\Dao\Cache::class,
		Framework\View\Logger::class => [
			'path' => $loc[File\Link::class]['path'] . '/logs',
		]
	]

];
