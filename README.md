# Email Scheduler

*CAUTION: This is not yet fully tested and may not work as expected.  Check back really really soon for a stable release.*

Thanks for stopping by.  The Email Scheduler was written for a friend in need.  As you find yourself here, perhaps I have made yet another friend in need.

Simply put, the Email Scheduler provides all the necessary tools (or most... ok some) to schedule and execute (send) email messages.

It has a silly PDO wrapper to make establishing database connections a little easier, but really it's here just so nothing is left wanting.  All the necessary pieces are available.

It has a Configuration namespace that you can use to configure both Mailer transports and Database connections.  Some configuration classes come built in, others you will have to build yourself.  These classes are completely optional, just as the PDO wrapper.

It has a nice and compact wrapper around SwiftMailer to make it easy to perform the duties at hand.  SMTP is provided for you, the rest you will have to build yourself.

It has scripts written for your automation needs in *src/shell* and *srs/shell/cron*.

# Prerequisites

This is a wrapper for SwiftMailer, really.  You need to install swift mailer.  You can install everything you need with Composer, if you are hip.  Otherwise, make sure you have the following:

	SwiftMailer >=5.0.3 (http://swiftmailer.org/)
	
	https://github.com/createvibe/php-cron-helper.git

I bet you noticed that second one.  Yeah, that's mine.  It's a Cron helper that you need for the CRON jobs.

# Installation

It is recommended that you use composer to install this package.  You can find information about installing composer at https://getcomposer.org/doc/00-intro.md

### Clone the repository

	$ git clone git@github.com:createvibe/email-scheduler.git
	
### Install with composer

	$ cd email-scheduler

	$ composer install

When composer is finished installing dependencies, it will generate a parameters file based on your input.  Once it has the parameters, it will attempt to install the email schedule database table for you.  Each step of the composer post-installation process allows you to skip it, so if you want to install the database yourself, you can do that.

# Manual Database Installation

In _resources, you can find the *email schedule* database schema.  You are expected to install this table schema in your database (the indexes are optional).

Assuming you have MySQL, you could do the following to install the schema:

	$ mysql -u root -p YOUR_DATABASE_NAME < _resources/schema.mysql.sql
	
# Usage Example

	// get the PDO connection
	$mysqlConfig = new EmailScheduler\Config\Database\Mysql('localhost', 'root', 'root');
	$mysqlConfig->setDatabaseName('email_scheduler');
	
	$pdo = new EmailScheduler\Database\Connection($mysqlConfig);

	// get the next 50 schedules to send within 10 attempts
	$repository = new EmailScheduler\Database\Repository\ScheduleRepository($pdo);
	$schedules = $repository->getNextSchedule(50, 10);

	// get a mailer
	$gmailConfig = new EmailScheduler\Configuration\Smtp\Gmail('username', 'password');
	$mailer = new EmailScheduler\Mailer\SmtpMailer($gmailConfig);

	// send the pending schedule
	$mailer->send($schedules);

	// update the schedule models
	$repository->updateSchedules($schedules);
