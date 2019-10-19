<?php
namespace Bappli\Studio;

use ITRocks\Framework\Component\Menu;

return [
	'IDE' => [
		'/Amos2/Ide/Programs' => 'Programs library'
	],
	'Administration' => [
		Menu::CLEAR,
		'/ITRocks/Framework/Users' => 'Users',
		'/ITRocks/Framework/User/Groups' => 'User groups',
		'/ITRocks/Framework/Logger/Entries' => 'Log entries',
		'/ITRocks/Framework/Locale/Translations' => 'Translations'
	]
];
