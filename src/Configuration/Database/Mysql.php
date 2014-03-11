<?php

namespace EmailScheduler\Configuration\Database;

class Mysql extends DatabaseConfiguration {
	
	/**
	 * {@inheritdoc}
	 */
	public function getDsn() {
		return 'mysql:' .
				'host=' . $this->host . 
				($this->port ? ';port=' . $this->port : '') . 
				';dbname=' . $this->databaseName;
	}
}