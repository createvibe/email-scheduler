<?php

namespace EmailScheduler\Configuration\Mailer;

class Factory {
	
	/**
	 * Get a Mailer Configuration object by its type
	 *
	 * @param string $type The mailer type (smtp)
	 * @param string $configurationType The configuraiton type (gmail)
	 * @param array $args Associative array of arguments for the configuration object (host, username, password, port)
	 * @return DatabaseConfiguration
	 * @throws \InvalidArgumentException
	 */
	static public function getConfiguration($type, $configurationType, array $args) {
		
		$class = self::getClassByType($type, $configurationType);
		
		if (!$class) {
			throw new \InvalidArgumentException($type . '.' . $configurationType . ' are not a valid types');
		}
		
		$username = isset($args['username']) ? $args['username'] ?: null : null;
		$password = isset($args['password']) ? $args['password'] ?: null : null;
		
		switch (strtolower($type) . '.' . strtolower($configurationType)) {
			case 'smtp.gmail' : {
				
				$config = new $class($username, $password);
				
				break;
			}
			
			default : {
				
				if (!isset($args['host'])) {
					throw new \InvalidArgumentException('You must provide a host');
				}
				
				$host = $args['host'];
				$port = isset($args['port']) ? $args['port'] ?: null : null;
				$ssl = isset($args['ssl']) ? $args['ssl'] ?: null : null;
				
				$config = new $class($host, $port, $username, $password, $ssl);
				
				break;
			}
		}
		
	
		return $config;
	}
	
	/**
	 * Get a Database Configuration class by its type (name)
	 *
	 * @param string $type The driver type (mysql, mssql, oracle, pgsql)
	 * @param string $configurationType The configuraiton type (gmail)
	 * @return string
	 */
	static public function getClassByType($type, $configurationType) {
		
		if (strtolower($type) === 'factory') {
			throw new \InvalidArgumentException('You may not get the factory from the factory');
		}
		
		$classPath = '\\EmailScheduler\\Configuration\\Mailer\\' . ucfirst($type) . '\\' . ucfirst($configurationType);
		
		if (class_exists($classPath) && 
			is_subclass_of($classPath, '\\EmailScheduler\\Configuration\\Configuration')) {
				
			return $classPath;
		}
		
		return null;
	}
}