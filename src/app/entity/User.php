<?php
class User {
	protected $email;
	protected $name;
	protected $surname;
	protected $password;
	protected $birthDate;

	public function __construct(array $data = NULL) {
		$this->hydrate($data);
	}

	public function hydrate(array $datas = NULL) {
		$attrib = get_class_vars(get_class($this));

		foreach ($attrib as $key => $val) {
			if (isset($datas[$key])) {
				$mutateur = 'set' . $key;
				$this->$mutateur($datas[$key]);
			}
		}
		return $this;
	}

	public function __toArray() {
		return $this->jsonSerialize();
	}

	public function jsonSerialize() {
		$array = array();

		$attrib = get_class_vars(get_class($this));

		foreach ($attrib as $key => $val) {
			$array[$key] = $this->get($key);
		}
		return $array;
	}

	protected function get($attribut) {
		return $this->$attribut;
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

	protected function setBirthDate($birthDate) {
		$this->birthDate = $birthDate;
	}
}
