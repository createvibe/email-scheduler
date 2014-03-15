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
Cron::singleton()->log('Pruning Delivered Schedules...');

// get the date to start pruning from
$d = new DateTime;
if (isset($params['schedule']) && 
	isset($params['schedule']['archive']) && 
	$params['shedule']['archive']) {

	$d->add(DateInterval::createFromDateString($params['schedule']['archive']));

} else {
	$d->add(DateInterval::createFromDateString('-21 days'));
}

Cron::singleton()->log('Deleting from ' . $d->format('Y-m-d H:i:s') . ' and earlier...');

// prune the delivered schedules
$repository->pruneDeliveredSchedules($d);

// release the lock, we are done
Cron::singleton()->log('Finished Pruning Delivered Schedules In ' . (microtime(true) - $timeStart) . ' seconds');
Cron::singleton()->unlock();
