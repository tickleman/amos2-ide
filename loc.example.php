<?php
use Amos2\Ide\Compiler;
use ITRocks\Framework\Configuration;
use ITRocks\Framework\Configuration\Environment;
use ITRocks\Framework\Dao\File;
use ITRocks\Framework\Dao\Mysql;
use ITRocks\Framework\Email\Sender\Smtp;

// Configure this with your locale configuration and rename this file to loc.php

$loc = [
	Compiler::class => [
		Compiler::PATH   => '/home/amos2/compiler',
		Compiler::OUTPUT => '/home/amos2/www/programs',
		Compiler::RUN    => 'http://programs.site'
	],
	Configuration::ENVIRONMENT => Environment::DEVELOPMENT,
	File\Link::class => ['class' => File\Link::class, 'path' => '/home/amos2/ide/files'],
	Mysql\Link::class => [
		Mysql\Link::DATABASE => 'amos2-ide',
		Mysql\Link::LOGIN    => 'amos2-user'
	],
	Smtp::class => [
		Smtp::HOST  => 'smtp.server.com',
		Smtp::LOGIN => 'smtp-login',
		Smtp::PORT  => 587
	]
];
