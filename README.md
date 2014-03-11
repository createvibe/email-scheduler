# Email Scheduler

Thanks for stopping by.  The Email Scheduler was written for a friend in need.  As you find yourself here, perhaps I have made yet another friend in need.

Simply put, the Email Scheduler provides all the necessary tools (or most... ok some) to schedule and execute (send) email messages.

It has a silly PDO wrapper to make establishing database connections a little easier, but really it's here just so nothing is left wanting.  All the necessary pieces are available.

It has a Configuration namespace that you can use to configure both Mailer transports and Database connections.  Some configuration classes come built in, others you will have to build yourself.  These classes are completely optional, just as the PDO wrapper.

It has a nice and compact wrapper around SwiftMailer to make it easy to perform the duties at hand.  SMTP is provided for you, the rest you will have to build yourself.

# Prerequisites

This is a wrapper for SwiftMailer, really.  You need to install swift mailer.  You can install everything you need with Composer, if you are hip.  Otherwise, make sure you have the following:

	SwiftMailer >=5.0.3 (http://swiftmailer.org/)
	
	https://github.com/createvibe/php-cron-helper.git

I bet you noticed that second one.  Yeah, that's mine.  It's a Cron helper that you need for the CRON jobs.

# Installation

In _resources, you''ll find the "email_schedule" database schema.  You are expected to install this table schema in your database (the indexes are optional).

Assuming you have MySql, you could do the following to install the schema:

	$ mysql -u root -p < _resources/schema.mysql.sql
	
# Usage Example

	// get the PDO connection
	$mysqlConfig = new EmailScheduler\Config\Database\Mysql('localhost', 'root', 'root');
	$conn = new EmailScheduler\Database\Connection($mysqlConfig);

	// get the next 20 emails scheduled to send
	$repository = new EmailScheduler\Database\Repository\ScheduleRepository($conn);
	$schedules = $repository->getNextSchedule(20);

	// get a mailer
	$gmailConfig = new EmailScheduler\Configuration\Smtp\Gmail('username', 'password');
	$mailer = new EmailScheduler\Mailer\SmtpMailer($gmailConfig);

	// send the pending schedule
	$mailer->send($schedules);

	// update the schedule models
	$repository->updateSchedules($schedules);
