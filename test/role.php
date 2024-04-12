<?php

require($_SERVER["DOCUMENT_ROOT"] . '/function/ft_header.php');
mainHeader("Role Test");

permissionChecker(true, array(ADMIN, STUDENT, TEACHER));
echo "Access!";
