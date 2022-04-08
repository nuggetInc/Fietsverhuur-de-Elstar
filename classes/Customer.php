<?php

declare(strict_types=1);

require_once("Database.php");

class Customer
{
    private int $id;
    private string $salutation;
    private string $name;
    private string $surname;
    private string $email;
    private string $phonenumber;
    private string $postalcode;

    private function __construct(int $id, string $salutation, string $name, string $surname, string $email, string $phonenumber, string $postalcode, string $address, string $comment)
    {
        $this->id = $id;
        $this->salutation = $salutation;
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->phonenumber = $phonenumber;
        $this->postalcode = $postalcode;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFullName(): string
    {
        return "{$this->salutation} {$this->name} {$this->surname}";
    }

    public function getSalutation(): string
    {
        return $this->salutation;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhonenumber(): string
    {
        return $this->phonenumber;
    }

    public function getPostalcode(): string
    {
        return $this->postalcode;
    }

    public static function getCustomer(int $id): ?Customer
    {
        $params = array(":id" => $id);
        $sth = Database::getPDO()->prepare("SELECT `id`, `salutation`, `name`, `surname`, `email`, `phonenumber`, `postalcode`, `address`, `comment` FROM `customer` WHERE `id` = :id;");
        $sth->execute($params);

        if ($row = $sth->fetch())
            return  new Customer($row["id"], $row["salutation"], $row["name"], $row["surname"], $row["email"], $row["phonenumber"], $row["postalcode"], $row["address"], $row["comment"]);

        return null;
    }

    public static function getAllCustomers(): array
    {
        $sth = Database::getPDO()->prepare("SELECT * FROM Customer");
        $sth->execute();
        return $sth->fetchAll();
    }

    public static function like($match): array
    {
        $params = array(":match" => $match);
        $sth = Database::getPDO()->prepare("SELECT `id`, `salutation`, `name`, `surname`, `email`, `phonenumber`, `postalcode`, `address`, `comment` FROM `customer` WHERE `postalcode` LIKE :match;");
        $sth->execute($params);

        $customers = array();

        while ($row = $sth->fetch())
        {
            $customers[$row["id"]] = new Customer($row["id"], $row["salutation"], $row["name"], $row["surname"], $row["email"], $row["phonenumber"], $row["postalcode"], $row["address"], $row["comment"]);
        }

        return $customers;
    }

    public static function update(int $id, string $salutation, string $name, string $surname, string $email, string $phonenumber, string $postalcode)
    {
        $params = array(":id" => $id, "salutation" => $salutation, "name" => $name, "surname" => $surname, "email" => $email, "phonenumber" => $phonenumber, "postalcode" => $postalcode);
        $sth = Database::getPDO()->prepare("UPDATE `customer` SET `salutation` = :salutation, `name` = :name, `surname` = :surname, `email` = :email, `phonenumber` = :phonenumber, `postalcode` = :postalcode  WHERE `id` = :id;");
        $sth->execute($params);
    }

    public static function create(string $salutation, string $name, string $surname, string $email, string $phonenumber, string $postalcode)
    {
        $params = array("salutation" => $salutation, "name" => $name, "surname" => $surname, "email" => $email, "phonenumber" => $phonenumber, "postalcode" => $postalcode);
        $sth = Database::getPDO()->prepare("INSERT INTO `customer` (`salutation`, `name`, `surname`, `email`, `phonenumber`, `postalcode`) VALUES (:salutation, :name, :surname, :email, :phonenumber, :postalcode);");
        $sth->execute($params);
    }
}
