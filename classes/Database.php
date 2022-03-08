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

    public static function hasEmployeeName(string $username): bool
    {
        $params = array(":name" => $username);
        $sth = self::getPDO()->prepare("SELECT 1 FROM `employee` WHERE `name` = :name;");
        $sth->execute($params);

        return $sth->rowCount() > 0;
    }

    public static function getEmployee(string $username): ?Employee
    {
        $params = array(":name" => $username);
        $sth = self::getPDO()->prepare("SELECT `name`, `permission` FROM `employee` WHERE `name` = :name;");
        $sth->execute($params);

        if ($row = $sth->fetch())
        {
            $name = $row["name"];
            $permission = Permission::from($row["permission"]);
            return new Employee($name, $permission);
        }

        return null;
    }

    public static function getEmployeeHash(Employee $user): ?string
    {
        $params = array(":name" => $user->GetName());
        $sth = self::getPDO()->prepare("SELECT `hash` FROM `employee` WHERE `name` = :name;");
        $sth->execute($params);

        return $sth->fetchColumn(0);
    }

    public static function registerEmployee(string $name, string $password, Permission $permission): Employee
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $params = array(":name" => $name, ":hash" => $hash, ":permission" => $permission->value);
        $sth = self::getPDO()->prepare("INSERT INTO `employee` (`name`, `hash`, `permission`) VALUES (:name, :hash, :permission);");
        $sth->execute($params);

        return new Employee($name, $permission);
    }
}
