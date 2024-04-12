<?php

require($_SERVER["DOCUMENT_ROOT"] . '/function/ft_header.php');
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
