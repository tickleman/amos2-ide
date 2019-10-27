<?php
namespace Bappli\Studio;

use ITRocks\Framework\Component\Menu;

return [
	'IDE' => [
		'/Amos2/Ide/Programs' => 'Programs library'
	],
	'User account' => [
		'/ITRocks/Framework/User/login' => 'Login',
		'/ITRocks/Framework/User/register' => 'Register new user'
	],
	'Administration' => [
		Menu::CLEAR,
		'/ITRocks/Framework/Users' => 'Users',
		'/ITRocks/Framework/User/Groups' => 'User groups',
		'/ITRocks/Framework/Logger/Entries' => 'Log entries',
		'/ITRocks/Framework/Locale/Translations' => 'Translations'
	]
];
