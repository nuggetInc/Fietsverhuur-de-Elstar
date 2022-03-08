<?php

declare(strict_types=1);

require_once("../classes/Employee.php");

session_start();

unset($_SESSION["user"]);

header("Location: ../");
exit;
