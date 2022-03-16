<?php 

declare(strict_types=1);

require_once("Database.php");

class Customer
{
    private string $customerId;

    public function setCustomerId($value) : void
    {
        $this->customerId = $value;
    }
    public function getCustomerById() : array
    {
        $params = array(":customerId"=> $this->customerId);
        $sth = Database::getPDO()->prepare("SELECT * FROM Customer WHERE id = :customerId");
        $sth->execute($params);
        return $sth->fetch();
    }
}

?>