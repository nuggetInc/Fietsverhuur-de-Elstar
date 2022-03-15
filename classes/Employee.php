<?php

declare(strict_types=1);

require_once("classes/Database.php");

class Employee
{
    private string $name;
    private string $hash;

    public function __construct(string $name, string $hash)
    {
        $this->name = $name;
        $this->hash = $hash;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public static function fromName(string $name): ?Employee
    {
        $params = array(":name" => $name);
        $sth = Database::getPDO()->prepare("SELECT `name`, `hash` FROM `employee` WHERE `name` = :name LIMIT 1;");
        $sth->execute($params);

        if ($row = $sth->fetch())
        {
            $name = $row["name"];
            $hash = $row["hash"];
            return new Employee($name, $hash);
        }

        return null;
    }

    public static function like($match): array
    {
        $params = array(":match" => $match);
        $sth = Database::getPDO()->prepare("SELECT `name`, `hash` FROM `employee` WHERE `name` LIKE :match;");
        $sth->execute($params);

        $employees = array();

        while ($row = $sth->fetch())
        {
            $name = $row["name"];
            $hash = $row["hash"];
            array_push($employees, new Employee($name, $hash));
        }

        return $employees;
    }

    public static function register(string $name, string $password): Employee
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $params = array(":name" => $name, ":hash" => $hash);
        $sth = Database::getPDO()->prepare("INSERT INTO `employee` (`name`, `hash`) VALUES (:name, :hash);");
        $sth->execute($params);

        return new Employee($name, $hash);
    }
}
