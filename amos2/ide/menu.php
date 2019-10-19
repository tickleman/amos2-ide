<?php
namespace Bappli\Studio;

use ITRocks\Framework\Component\Menu;

return [
	'Administration' => [
		Menu::CLEAR,
		'/ITRocks/Framework/Users' => 'Users',
		'/ITRocks/Framework/User/Groups' => 'User groups',
		'/ITRocks/Framework/Logger/Entries' => 'Log entries',
		'/ITRocks/Framework/Locale/Translations' => 'Translations'
	]
];
