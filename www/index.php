<?php

if (file_exists(__DIR__ . '/../temp/maintenance')) {
	if (isset($_GET['maintenanceOff']) || (isset($argv) && $argv[1] == 'maintenanceOff')) {
		unlink(__DIR__ . '/../temp/maintenance');
		echo "Maintenance off\n";
		exit;
	}
	require '.maintenance.php';
}

if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
	$_SERVER['HTTPS'] = 'on';
	$_SERVER['SERVER_PORT'] = '443';
}

$container = require __DIR__ . '/../app/bootstrap.php';

$container->getByType(Nette\Application\Application::class)->run();
