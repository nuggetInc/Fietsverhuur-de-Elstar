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

    public function hasEmployeeName(string $username): bool
    {
        $params = array(":name" => $username);
        $sth = self::getPDO()->prepare("SELECT 1 FROM `employee` WHERE `name` = :name LIMIT 1;");
        $sth->execute($params);

        return $sth->rowCount() > 0;
    }

    public function getEmployee(string $username): ?Employee
    {
        $params = array(":name" => $username);
        $sth = self::getPDO()->prepare("SELECT `name` FROM `employee` WHERE `name` = :name LIMIT 1;");
        $sth->execute($params);

        if ($row = $sth->fetch())
        {
            $name = $row["name"];
            return new Employee($name);
        }

        return null;
    }

    public function getEmployeesLike(string $match): array
    {
        $params = array(":match" => $match);
        $sth = self::getPDO()->prepare("SELECT `name` FROM `employee` WHERE `name` LIKE :match;");
        $sth->execute($params);

        $employees = array();

        while ($row = $sth->fetch())
        {
            $name = $row["name"];
            array_push($employees, new Employee($name));
        }

        return $employees;
    }

    public function getEmployeeHash(Employee $user): ?string
    {
        $params = array(":name" => $user->getName());
        $sth = self::getPDO()->prepare("SELECT `hash` FROM `employee` WHERE `name` = :name LIMIT 1;");
        $sth->execute($params);

        return $sth->fetchColumn(0);
    }

    public function registerEmployee(string $name, string $password): Employee
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $params = array(":name" => $name, ":hash" => $hash);
        $sth = self::getPDO()->prepare("INSERT INTO `employee` (`name`, `hash`) VALUES (:name, :hash);");
        $sth->execute($params);

        return new Employee($name);
    }
}
