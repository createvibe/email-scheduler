<?php

namespace EmailScheduler\Configuration\Mailer\Smtp;

use EmailScheduler\Configuration\Mailer\MailerConfiguration;

class Gmail extends MailerConfiguration {
	
	/**
	 * The Host 
	 *
	 * @type string
	 */
	protected $host = 'smtp.gmail.com';
	
	/**
	 * The Port
	 *
	 * @type int
	 */
	protected $port = 465;
	
	/**
	 * The SSL boolean flag
	 *
	 * @type bool
	 */
	protected $ssl = true;
	
	/**
	 * Construct this configuration object
	 *
	 * @constructor
	 * @param string|null $username
	 * @param string|null $password
	 */
	public function __construct($username=null, $password=null) {
		$this->username = $username;
		$this->password = $password;
	}
}