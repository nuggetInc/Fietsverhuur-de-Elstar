<?php

declare(strict_types=1);

require_once("Employee.php");

class Database
{
    public static function getPDO(): PDO
    {
        static $pdo = new PDO("mysql:host=localhost;dbname=fietsverhuur_de_elstar", "root", "");

        return $pdo;
    }
}
