<?php

declare(strict_types=1);

require_once("classes/Database.php");
require_once("classes/Employee.php");

session_start();

if (empty($_REQUEST["name"]))
{
    $_SESSION["login-error"] = "Username is empty :(";
    $_SESSION["login-name-error"] = true;

    header("Location: ./");
    exit;
}

if (empty($_REQUEST["password"]))
{
    $_SESSION["login-error"] = "Password is empty :(";
    $_SESSION["login-password-error"] = true;

    header("Location: ./");
    exit;
}

if (Database::hasEmployeeName($_REQUEST["name"]))
{
    $user = Database::getEmployee($_REQUEST["name"]);
    $hash = Database::getEmployeeHash($user);

    if (password_verify($_REQUEST["password"], $hash))
    {
        $_SESSION["user"] = $user;

        unset($_SESSION["login-name"]);

        header("Location: home/");
        exit;
    }
}

$_SESSION["login-error"] = "Username or password is incorrect :(";
$_SESSION["login-name-error"] = true;
$_SESSION["login-password-error"] = true;

header("Location: ./");
exit;
