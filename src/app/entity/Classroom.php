<?php

namespace LabSupervisor\app\entity;

class Classroom	{
	protected $name;
	protected $id;

	public function __construct(array $data = NULL) {
		$variable = get_class_vars(get_class($this));

		foreach ($variable as $key => $val) {
			if (isset($data[$key])) {
				$mutateur = 'set' . $key;
				$this->$mutateur($data[$key]);
			}
		}
	}

	public function __toArray() {
		$array = array();

		$variable = get_class_vars(get_class($this));

		foreach ($variable as $key => $val) {
			$array[$key] = $this->get($key);
		}
		return $array;
	}

	protected function get($variable) {
		return $this->$variable;
	}

	protected function setName($name) {
		$this->name = $name;
	}

	protected function setId($id) {
		if (isset($id)) {
			$this->id = $id;
		}
	}
}

