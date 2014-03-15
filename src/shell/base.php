<?php

/**
 * Base Cron Include
 */

// include the vendor autoloader
$autoLoader = require __DIR__ . '/../../vendor/autoload.php';

// get the configutration parameters
$params = require __DIR__ . '/../EmailScheduler/Resources/config/parameters.php';

// initialize the pdo Connection 
$db = new EmailScheduler\Database\Connection(EmailScheduler\Configuration\Database\Factory::getConfiguration(
	$params['database']['type'] , 
	$params['database']
));

// initialize the Schedule Repository
$repository = new EmailScheduler\Database\Repository\ScheduleRepository($db);

// initialize the Mailer
$mailer = EmailScheduler\Mailer\Factory::getMailerByType($params['mailer']['type'], EmailScheduler\Configuration\Mailer\Factory::getConfiguration(
	$params['mailer']['type'] , 
	$params['mailer']['configuration'] , 
	$params['mailer']
));