<?php

declare(strict_types=1);

require_once("Employee.php");
require_once("Permission.php");

class Database
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO("mysql:host=localhost;dbname=fietsverhuur_de_elstar", "root", "");
    }

    public function hasEmployeeName(string $username): bool
    {
        $params = array(":name" => $username);
        $sth = $this->pdo->prepare("SELECT 1 FROM `employee` WHERE `name` = :name;");
        $sth->execute($params);

        return $sth->rowCount() > 0;
    }

    public function getEmployee(string $username): ?Employee
    {
        $params = array(":name" => $username);
        $sth = $this->pdo->prepare("SELECT `name`, `permission` FROM `employee` WHERE `name` = :name;");
        $sth->execute($params);

        if ($row = $sth->fetch())
        {
            $name = $row["name"];
            $permission = Permission::from($row["permission"]);
            return new Employee($name, $permission);
        }

        return null;
    }

    public function getEmployeeHash(Employee $user): ?string
    {
        $params = array(":name" => $user->GetName());
        $sth = $this->pdo->prepare("SELECT `hash` FROM `employee` WHERE `name` = :name;");
        $sth->execute($params);

        return $sth->fetchColumn(0);
    }

    public function registerEmployee(string $name, string $password, Permission $permission): Employee
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $params = array(":name" => $name, ":hash" => $hash, ":permission" => $permission->value);
        $sth = $this->pdo->prepare("INSERT INTO `employee` (`name`, `hash`, `permission`) VALUES (:name, :hash, :permission);");
        $sth->execute($params);

        return new Employee($name, $permission);
    }
}
