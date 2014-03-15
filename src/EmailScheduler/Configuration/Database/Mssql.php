<?php

namespace EmailScheduler\Configuration\Database;

class Mssql extends DatabaseConfiguration {
	
	/**
	 * {@inheritdoc}
	 */
	public function getDsn() {
		return 'mssql:' .
				'host=' . $this->host . 
				($this->port ? ';port=' . $this->port : '') . 
				';dbname=' . $this->databaseName;
	}
}