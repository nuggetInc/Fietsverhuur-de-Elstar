<?php 

declare(strict_types=1);

require_once("Database.php");

class Bike 
{
    public static function getTotalBikeCount() : int
    {
        $sth = Database::getPDO()->prepare("SELECT * FROM Bike");
        $sth->execute();
        return $sth->rowCount();
    }
}

?>