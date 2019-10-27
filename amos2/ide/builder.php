<?php

use ITRocks\Framework;

return [
	Framework\User::class => [
		Framework\User\Group\Has_Groups::class
	],
	Framework\User\Group::class => [
		Framework\User\Group\Has_Default::class,
		Framework\User\Group\Has_Guest::class
	]
];
