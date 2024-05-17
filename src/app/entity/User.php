<?php

namespace LabSupervisor\app\entity;

class User {
	protected $email;
	protected $name;
	protected $surname;
	protected $password;

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

	protected function setEmail($email) {
		$this->email = $email;
	}

	protected function setName($name) {
		$this->name = $name;
	}

	protected function setSurname($surname) {
		$this->surname = $surname;
	}

	protected function setPassword($password) {
		$this->password = $password;
	}
}
