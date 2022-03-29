<?php 

declare(strict_types=1);

require_once("Database.php");

class Customer
{
    private int $customerId;

    public function setCustomerId($value) : bool
    {
        $params = array(":customerId"=> $value);
        $sth = Database::getPDO()->prepare("SELECT * FROM Customer WHERE id = :customerId");
        $sth->execute($params);

        $this->customerId = $value;
        return $sth->rowCount() >= 1;
        
    }
    public function getCustomerById() : array
    {
        $params = array(":customerId"=> $this->customerId);
        $sth = Database::getPDO()->prepare("SELECT * FROM Customer WHERE id = :customerId");
        $sth->execute($params);
        return $sth->fetch();
    }
    public static function getAllCustomers() : array
    {
        $sth = Database::getPDO()->prepare("SELECT * FROM Customer");
        $sth->execute();
        return $sth->fetchAll();
    }
}

?>