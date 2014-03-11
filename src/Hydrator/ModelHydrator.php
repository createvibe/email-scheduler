<?php

namespace EmailSchedule\Hydrator\ModelHydrator;

class ModelHydrator implements HydratorInterface {
	
	public function hydrate($obj, $data) {

		foreach ($data as $key => $value) {
			if (isset($obj->$key)) {

				$obj->$key = $value;

			} elseif (method_exists($obj, 'set' . $key)) {

				$obj->{'set' . $key}($value);

			} elseif (false !== ($idx = strpos($key, '_'))) {

				$useKey = preg_replace_callback('/_[a-z]/i', function($matches) {
					return strtoupper(ltrim($matches[0], '_'));
				}, $key);

				if (isset($obj->$useKey)) {

					$obj->$useKey = $value;

				} elseif (method_exists($obj, 'set' . $useKey)) {

					$obj->{'set' . $useKey}($value);
				}
			}
		}
		
		return $obj;
	}
}