<?php

require __DIR__ . '/../base.php';

Cron::singleton()->setLockPath(__DIR__ . '/pids/');
Cron::singleton()->setLogPath(__DIR__ . '/logs/');

// attempt to acquire a lock
if (!Cron::singleton()->lock()) {
	// lock failed (already running?)
	exit;
}

$timeStart = microtime(true);
Cron::singleton()->log('Delivering Scheduled Emails...');

// get the next 50 schedules to send within 10 attempts
$schedules = $repository->getNextSchedule(50, 10);

Cron::singleton()->log('Found Schedules: ' . count($schedules));

// send the pending schedule
$mailer->send($schedules);

// update the schedules
$repository->updateSchedules($schedules);

// release the lock, we are done
Cron::singleton()->log('Finished Delivering Scheduled Emails In ' . (microtime(true) - $timeStart) . ' seconds');
Cron::singleton()->unlock();
