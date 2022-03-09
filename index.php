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
    <title>Login</title>
</head>

<body>
    <?php

    if (isset($_SESSION["user"]))
    {
        unset($_SESSION["user"]);
        // require("home.php");
    }
    else
    {
        require("login.php");
    }

    ?>
</body>

</html>