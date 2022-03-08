<?php

declare(strict_types=1);

require_once("classes/Employee.php");

session_start();

if (isset($_SESSION["user"]))
{
    header("Location: home/");
    exit;
}

?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>

<body>
    <form action="login.php" method="POST">
        <label>Username
            <input type="text" name="name" placeholder="Username" maxlength="24" required />
        </label>
        <label>Password
            <input type="password" name="password" placeholder="Password" required />
        </label>
        <input class="submit" type="submit" value="Login" />
    </form>
</body>

</html>