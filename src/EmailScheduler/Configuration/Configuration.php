<?php

namespace EmailScheduler\Configuration;

class Configuration {
	
	/**
	 * The Host 
	 *
	 * @type string
	 */
	protected $host;
	
	/**
	 * The Port
	 *
	 * @type int
	 */
	protected $port;
	
	/**
	 * The Username
	 *
	 * @type string|null
	 */
	protected $username;
	
	/**
	 * The Password
	 *
	 * @type string|null
	 */
	protected $password;
	
	/**
	 * The SSL boolean flag
	 *
	 * @type bool
	 */
	protected $ssl = false;
	
	/**
	 * Construct this confguration object
	 *
	 * @constructor
	 * @param string $host
	 * @param int $port
	 * @param string|null $username
	 * @param string|null $password
	 * @param bool|null $ssl
	 */
	public function __construct($host, $port=25, $username=null, $password=null, $ssl=false) {
		$this->host = $host;
		$this->port = $port;
		$this->username = $username;
		$this->password = $password;
		$this->ssl = (bool)$ssl;
	}
	
	/**
	 * Get the host
	 *
	 * @return string
	 */
	public function getHost() {
		return $this->host;
	}
	
	/**
	 * Get the port
	 *
	 * @return int
	 */
	public function getPort() {
		return $this->port;
	}
	
	/**
	 * Get the username
	 *
	 * @return string
	 */
	public function getUsername() {
		return $this->username;
	}
	
	/**
	 * Get the password
	 *
	 * @return string
	 */
	public function getPassword() {
		return $this->password;
	}
	
	/**
	 * Get the SSL flag
	 *
	 * @return bool
	 */
	public function isSsl() {
		return (bool)$this->ssl;
	}
}