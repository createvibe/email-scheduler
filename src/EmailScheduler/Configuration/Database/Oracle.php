<?php

namespace EmailScheduler\Configuration\Database;

class Oracle extends DatabaseConfiguration {
	
	/**
	 * {@inheritdoc}
	 */
	public function getDsn() {
		$dsn = 'oci:dbname=';
		
		if ($this->host) {
			$dsn .= '//' . $this->host;
			
			if ($this->port) {
				$dsn .= ':' . $this->port;
			}
			
			$dsn .= '/';
		}
		
		$dsn .= $this->databaseName;
		
		return $dsn;
	}
}