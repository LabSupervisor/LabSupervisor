<?php

use
	PHPUnit\Framework\TestCase,
	LabSupervisor\app\repository\UserRepository;

require_once dirname(__FILE__) . "/../test/import.php";

final class UserTest extends TestCase
{
	public function testGetId(): void
	{
		$email = 'admin@gmail.com';
		$id = 101;

		$getId = UserRepository::getId($email);

		$this->assertEquals($getId, $id);
	}
}
