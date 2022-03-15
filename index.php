<?php

declare(strict_types=1);

require_once("classes/Database.php");
require_once("classes/Employee.php");
require_once("classes/Page.php");

session_start();

?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/reserve.css">
    <title>Login</title>
</head>

<body>
    <?php if (isset($_SESSION["user"])) : ?>
        <?php

        $page = $_GET["page"] ?? "";
        $children = Page::getRootChildren();

        ?>
        <header id="header">
            <?php require("header.php"); ?>
        </header>
        <div class="page-wrapper">
            <?php require("pages/{$current->getName()}.php"); ?>
        </div>
    <?php else : ?>
        <?php require("pages/login.php"); ?>
    <?php endif ?>
</body>

</html>