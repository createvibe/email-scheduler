<?php

namespace EmailScheduler\Configuration\Smtp;

class Gmail extends Configuration {
	
	/**
	 * The Host 
	 *
	 * @type string
	 */
	protected $host = 'smtp.google.com';
	
	/**
	 * The Port
	 *
	 * @type int
	 */
	protected $port = 467;
	
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