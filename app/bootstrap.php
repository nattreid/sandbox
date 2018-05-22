<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
	$_SERVER['HTTPS'] = 'on';
	$_SERVER['SERVER_PORT'] = '443';
}

// prava pro temp atd
umask(0);

$configurator = new Nette\Configurator;

//$configurator->setDebugMode('23.75.345.200'); // enable for your remote IP
$configurator->enableDebugger(__DIR__ . '/../log');

$configurator->setTimeZone('Europe/Prague');
$configurator->setTempDirectory(__DIR__ . '/../temp');

$configurator->createRobotLoader()
	->addDirectory(__DIR__)
	->register();

$configurator->addConfig(__DIR__ . '/config/config.neon');
$configurator->addConfig(__DIR__ . '/config/project.neon');
$configurator->addConfig(__DIR__ . '/config/webLoader.neon');
$configurator->addConfig(__DIR__ . '/config/config.local.neon');

$configurator->addParameters([
	'logDir' => __DIR__ . '/../log',
	'sessionDir' => __DIR__ . '/../temp/sessions'
]);

$container = $configurator->createContainer();

return $container;
