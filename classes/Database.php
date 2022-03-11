<?php

declare(strict_types=1);

require_once("Employee.php");

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
        $sth = $this->pdo->prepare("SELECT 1 FROM `employee` WHERE `name` = :name; LIMIT 1");
        $sth->execute($params);

        return $sth->rowCount() > 0;
    }

    public function getEmployee(string $username): ?Employee
    {
        $params = array(":name" => $username);
        $sth = $this->pdo->prepare("SELECT `name` FROM `employee` WHERE `name` = :name LIMIT 1;");
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
        $sth = $this->pdo->prepare("SELECT `name` FROM `employee` WHERE `name` LIKE :match;");
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
        $sth = $this->pdo->prepare("SELECT `hash` FROM `employee` WHERE `name` = :name LIMIT 1;");
        $sth->execute($params);

        return $sth->fetchColumn(0);
    }

    public function registerEmployee(string $name, string $password): Employee
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $params = array(":name" => $name, ":hash" => $hash);
        $sth = $this->pdo->prepare("INSERT INTO `employee` (`name`, `hash`) VALUES (:name, :hash);");
        $sth->execute($params);

        return new Employee($name);
    }
}
