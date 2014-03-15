<?php

namespace EmailScheduler\Database\Repository;

class Repository {
	
	/**
	 * The PDO instance
	 *
	 * @type \PDO
	 */
	protected $pdo;
	
	/**
	 * Construct this class with a PDO instance
	 *
	 * @constructor
	 * @param \PDO $pdo
	 */
	public function __construct(\PDO $pdo) {
		$this->pdo = $pdo;
	}
}