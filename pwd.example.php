<?php
use ITRocks\Framework\Dao\Mysql;
use ITRocks\Framework\Email\Sender\Smtp;

// Configure this with your passwords configuration and rename this file to pwd.php

$pwd = [
	Mysql\Link::class => 'database-password',
	Smtp::class => 'smtp-password'
];
