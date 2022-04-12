<?php

declare(strict_types=1);

require_once("classes/Database.php");
require_once("classes/Employee.php");
require_once("classes/Bike.php");
require_once("classes/BikeRental.php");
require_once("classes/Page.php");
require_once("classes/Customer.php");
require_once("classes/ReserveTable.php");

session_start();

const ROOT = "/Fietsverhuur-de-Elstar/";

?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/form.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/reserve.css">
    <link rel="stylesheet" href="./css/table.css">
    <title>Fietsverhuur</title>
</head>

<body>
    <?php

    $uri = $_SERVER["REQUEST_URI"];

    ?>
    <?php if (isset($_SESSION["user"])) : ?>
        <?php

        $children = Page::getRootChildren();

        ?>
        <header id="header">
            <?php require("header.php"); ?>
        </header>
        <div class="page-wrapper">
            <?php require("pages/{$current->getName()}.php"); ?>
        </div>
    <?php else : ?>
        <div class="page-wrapper">
            <?php require("login.php"); ?>
        </div>
    <?php endif ?>
    <footer>Copyright © 2022 De Elstar. All rights reserved</footer>
</body>

</html>