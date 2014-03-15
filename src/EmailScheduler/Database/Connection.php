<?php

namespace EmailScheduler\Database;

use EmailScheduler\Configuration\Database\DatabaseConfiguration;

class Connection extends \PDO {
	
	/**
	 * Construct this class with a DatabaseConfiguration object
	 *
	 * @constructor
	 * @param DatabaseConfiguration $configuration
	 */
	public function __construct(DatabaseConfiguration $configuration) {
		
		parent::__construct(
			$configuration->getDsn(), 
			$configuration->getUsername(), 
			$configuration->getPassword(), 
			$configuration->getDriverOptions()
		);
	}
}