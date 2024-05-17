<?php

namespace LabSupervisor\app\entity;

class Session {

	protected $title;
	protected $description;
	protected $idclassroom;
	protected $idcreator;
	protected $date;
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

	protected function setTitle($title) {
		$this->title = $title;
	}

	protected function setDescription($description) {
		$this->description = $description;
	}

	protected function setIdClassroom($idclassroom) {
		$this->idclassroom = $idclassroom;
	}

	protected function setIdCreator($idcreator) {
		$this->idcreator = $idcreator;
	}

	protected function setDate($date) {
		$this->date = $date;
	}

	protected function setId($id) {
		if (isset($id)) {
			$this->id = $id;
		}
	}

}

