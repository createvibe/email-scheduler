<?php

namespace EmailScheduler\Configuration\Database;

class Factory {
	
	/**
	 * Get a Database Configuration object by its type
	 *
	 * @param string $type The driver type (mysql, mssql, oracle, pgsql)
	 * @param array $args Associative array of arguments for the configuration object (host, username, password, driverOptions, port)
	 * @return DatabaseConfiguration
	 * @throws \InvalidArgumentException
	 */
	static public function getConfiguration($type, array $args) {
		
		$class = self::getClassByType($type);
		
		if (!$class) {
			throw new \InvalidArgumentException($type . ' is not a valid type');
		}
		
		if (!isset($args['host'])) {
			throw new \InvalidArgumentException('You must provide a host');
		}
		
		$host = $args['host'];
		$username = isset($args['username']) ? $args['username'] ?: null : null;
		$password = isset($args['password']) ? $args['password'] ?: null : null;
		$driverOptions = isset($args['driverOptions']) ? $args['driverOptions'] ?: null : null;
		$port = isset($args['port']) ? $args['port'] ?: null : null;
		
		$config = new $class($host, $username, $password, $driverOptions);
		
		if ($port) {
			$config->setPort($port);
		}
		
		return $config;
	}
	
	/**
	 * Get a Database Configuration class by its type (name)
	 *
	 * @param string $type The driver type (mysql, mssql, oracle, pgsql)
	 * @return string
	 */
	static public function getClassByType($type) {
		
		if (strtolower($type) === 'factory') {
			throw new \InvalidArgumentException('You may not get the factory from the factory');
		}
		
		$classPath = '\\EmailScheduler\\Configuration\\Database\\' . ucfirst($type);
		
		if (class_exists($classPath) && 
			is_subclass_of($classPath, '\\EmailScheduler\\Configuration\\Database\\DatabaseConfiguration')) {
				
			return $classPath;
		}
		
		return null;
	}
}