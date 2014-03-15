<?php

namespace EmailScheduler\Configuration\Database;

use EmailScheduler\Configuration\Configuration;

abstract class DatabaseConfiguration extends Configuration {
	
	/**
	 * The database name
	 *
	 * @type string
	 */
	protected $databaseName = 'email_scheduler';
	
	/**
	 * The port (if null, none is used)
	 *
	 * @type int|null
	 */
	protected $port = null;
	
	/**
	 * Driver options
	 * 
	 * @type array|null
	 */
	protected $driverOptions = null;

	/**
	 * Construct this Database Configuration object
	 *
	 * @constructor
	 * @param string $host The hostname to the database server
	 * @param string|null $username The username for the database connection
	 * @param string|null $password The password for the database connection
	 * @param array|null $driverOptions The driver options for this connection
	 */
	public function __construct($host, $username=null, $password=null, array $driverOptions=null) {
		
		parent::__construct($host, null, $username, $password, true);
		
	}
	
	/**
	 * Get the DSN Connection String for this database configuration
	 *
	 * @returns string
	 */
	abstract public function getDsn();
	
	/**
	 * Set the database name
	 * 
	 * @param string $databaseName
	 * @return DatabaseConnection Fluent interface (this object) 
	 */
	public function setDatabaseName($databaseName) {
		$this->databaseName = $databaseName;
		return $this;
	}
	
	/**
	 * Get the database name
	 *
	 * @return string
	 */
	public function getDatabaseName() {
		return $this->databaseName;
	}
	
	/**
	 * Set the port
	 *
	 * @param int $port
	 * @return Configuration This object (fluent interface)
	 */
	public function setPort($port) {
		$this->port = $port;
		return $this;
	}
	
	/**
	 * Set the driver options
	 *
	 * @param array $options
	 * @return DatabaseConfiguration This object (fluent interface)
	 */
	public function setDriverOptions(array $options) {
		$this->driverOptions = $options;
		return $this;
	}
	
	/**
	 * Get the driver options
	 *
	 * @returns array|null
	 */
	public function getDriverOptions() {
		return $this->driverOptions;
	}
}