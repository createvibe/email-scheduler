<?php

namespace EmailScheduler\Database;

class Connection extends \PDO {
	
	/**
	 * Construct this class with a DatabaseConfiguration object
	 *
	 * @constructor
	 * @param DatabaseConfiguration $configuration
	 */
	public function __construct(DatabaseConfiguration $configuration) {
		
		parent::construct(
			$configuration->getDsn(), 
			$configuration->getUsername(), 
			$configuration->getPassword(), 
			$configuration->getDriverOptions()
		);
	}
}