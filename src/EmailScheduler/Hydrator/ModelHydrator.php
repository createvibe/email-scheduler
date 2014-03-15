<?php

namespace EmailScheduler\Hydrator;

/**
 * The ModelHydrator maps an associative array of data to an object
 */
class ModelHydrator implements HydratorInterface {
	
	/**
	 * {@inheritdoc}
	 */
	public function hydrate($obj, $data) {

		foreach ($data as $key => $value) {
			if (method_exists($obj, 'set' . $key)) {

				$obj->{'set' . $key}($value);

			} elseif (property_exists($obj, $key)) {

				$obj->$key = $value;

			} elseif (false !== strpos($key, '_')) {

				// convert field_name to fieldName
				$useKey = preg_replace_callback('/_[a-z]/i', function($matches) {
					return strtoupper(ltrim($matches[0], '_'));
				}, $key);

				if (method_exists($obj, 'set' . $useKey)) {

					$obj->{'set' . $useKey}($value);

				} elseif (property_exists($obj, $useKey)) {

					$obj->$useKey = $value;
				}
			}
		}
		
		return $obj;
	}
}