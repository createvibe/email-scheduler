<?php

namespace EmailScheduler\Configuration\Database;

class Pgsql extends DatabaseConfiguration {
	
	/**
	 * {@inheritdoc}
	 */
	public function getDsn() {
		return 'pgsql:' .
				'host=' . $this->host . 
				($this->port ? ' port=' . $this->port : '') . 
				' dbname=' . $this->databaseName;
	}
}