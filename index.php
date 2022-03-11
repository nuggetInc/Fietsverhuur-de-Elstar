<?php

declare(strict_types=1);

require_once("classes/Database.php");
require_once("classes/Employee.php");

session_start();

$database = new Database();

?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/reserve.css">
    <title>Login</title>
</head>

<body>
    <?php

    if (isset($_SESSION["user"]))
    {
        require("pages/home.php");
    }
    else
    {
        require("pages/login.php");
    }

    ?>
</body>

</html>