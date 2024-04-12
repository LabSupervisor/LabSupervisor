<?php

use LabSupervisor\app\repository\ClassroomRepository;
use LabSupervisor\app\entity\Classroom;
use function LabSupervisor\functions\mainHeader;

mainHeader("Classroom Test");

$classroomRepo = new ClassroomRepository();

$classroomData = array(
	"name" => "test"
);

$classroom = new Classroom($classroomData);
$classroomRepo->createClassroom($classroom);

echo "<br>" . ClassroomRepository::getId($classroomData["name"]);
echo "<br>" . ClassroomRepository::isActive($classroomData["name"]);

echo "<form method='post'><input type='hidden' name='name' value='" . $classroomData["name"] . "'><input type='submit' name='delete' value='Delete'/></form>";

if (isset($_POST["delete"])) {
	ClassroomRepository::delete($_POST["name"]);
	header("Location: /");
}
