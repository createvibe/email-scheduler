<?php

/**
 * Base Shell Include
 */

// include the vendor autoloader
$autoLoader = require __DIR__ . '/../../vendor/autoload.php';

// get the configutration parameters
$params = require __DIR__ . '/../EmailScheduler/Resources/config/parameters.php';

// initialize the pdo Connection 
$databaseConfiguration = \EmailScheduler\Configuration\Database\Factory::getConfiguration($params['database']['type'], $params['database']);
$databaseConfiguration->setDatabaseName($params['database']['name']);
$db = new EmailScheduler\Database\Connection($databaseConfiguration);

// initialize the Schedule Repository
$repository = new EmailScheduler\Database\Repository\ScheduleRepository($db);

// initialize the Mailer
$mailerConfiguration = EmailScheduler\Configuration\Mailer\Factory::getConfiguration(
	$params['mailer']['type'] , 
	$params['mailer']['configuration'] , 
	$params['mailer']
);
$mailerConfiguration->setContentType($params['mailer']['contentType']);
$mailer = EmailScheduler\Mailer\Factory::getMailerByType($params['mailer']['type'], $mailerConfiguration);
