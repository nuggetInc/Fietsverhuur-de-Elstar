<?php 

declare(strict_types=1);

require_once("Database.php");

class Bike 
{
    public function getTotalBikeCount()
    {
        $sth = Database::getPDO()->prepare("SELECT * FROM Bike");
        $sth->execute();
        return $sth->rowCount();
    }
}

?>