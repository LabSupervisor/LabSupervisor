<?php

use function LabSupervisor\functions\mainHeader;
use function LabSupervisor\functions\permissionChecker;

mainHeader("Role Test");

permissionChecker(true, array(ADMIN, STUDENT, TEACHER));
echo "Access!";
