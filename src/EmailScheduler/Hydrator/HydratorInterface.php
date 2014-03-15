<?php

namespace EmailScheduler\Hydrator;

interface HydratorInterface {
	
	/**
	 * Hydrate an object
	 *
	 * @param mixed $obj
	 * @param mixed $data
	 * @return void
	 */
	public function hydrate($obj, $data);
}