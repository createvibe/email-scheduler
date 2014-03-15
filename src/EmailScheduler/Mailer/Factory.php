<?php

namespace EmailScheduler\Mailer;

use EmailScheduler\Configuration\Configuration;

class Factory {
	
	/**
	 * Get a Mailer object by its configuration
	 *
	 * @param string $type The type of mailer (smtp)
	 * @param Configuration $config The configuration
	 * @return Configuration
	 * @throws \InvalidArgumentException
	 */
	static public function getMailerByType($type, Configuration $config) {
		
		$class = self::getClassByType($type);
		
		if (!$class) {
			throw new \InvalidArgumentException($type . ' is not a valid type');
		}
		
		return new $class($config);
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
		
		$classPath = '\\EmailScheduler\\Mailer\\' . ucfirst($type) . 'Mailer';
		
		if (class_exists($classPath) && 
			is_subclass_of($classPath, '\\EmailScheduler\\Mailer\\AbstractMailer')) {
				
			return $classPath;
		}
		
		return null;
	}
}