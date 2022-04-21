<?php 

declare(strict_types=1);

require_once("Database.php");

class BikeRental 
{
    private string $dateFrom;
    private string $dateTo;
    private int $numberOfPeople;
    private int $customerId;
    private int $childSeat;
    private string $comment;
    private static string $queryString = "AND status = ";
    private string $status;
    
    public function __construct(int $numberOfPeople, int $customerId, string $dateFrom, string $dateTo, int $childSeat, string $comment)
    {
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->numberOfPeople = $numberOfPeople;
        $this->customerId = $customerId;
        $this->childSeat = $childSeat;
        $this->comment = $comment;

        $this->status = BikeRental::$queryString . 1;
    }
    /**
     * Gets bikerental in between dates.
     */
    public static function getBikeRentals(array $dates) : array
    {
        $params = array(":dateFrom"=>date("Y-m-d", strtotime($dates["dateFrom"])), ":dateTo"=>date("Y-m-d", strtotime($dates["dateTo"])));
        $sth = Database::getPDO()->prepare("SELECT * FROM bike_rental WHERE date_from >= :dateFrom AND date_to <= :dateTo");
        $sth->execute($params);

        if($row = $sth->fetchAll())
            return $row;
        return array();
    }
    public static function getCountByDate(string $date) : int
    {
        $params = array(":date"=>date("Y-m-d", strtotime($date)));
        $sth = Database::getPDO()->prepare("SELECT * FROM bike_rental WHERE date_from <= :date AND date_to >= :date");
        $sth->execute($params);

        return $sth->rowCount();

    }

    /** 
     * enter a number referring to the status:
     * 0=Get all
     * 1=reserved 
     * 2=rented_out
     * 3=returned*/
    public function setStatus($value) : void 
    {
        $this->status = ($value == 0) ? "" : BikeRental::$queryString . $value;
    }

    /** 
     * Adds to BikeRental table.
     * Param = $_SESSION["user"]
    */
    public static function addBikeRental(int $numberOfPeople, int $customerId, string $dateFrom, string $dateTo, int $childSeat, string $comment)
    {
        $childSeat = $childSeat;
        for($i = 0; $i < $numberOfPeople; $i++)
        {
            $childSeat = ($childSeat != 0) ? $childSeat / $childSeat : 0;

            $params = array(':date_from'=>$dateFrom, ':date_to'=>$dateTo, 
            ':employee_name'=>$_SESSION["user"]->getName(), 'customer_id'=>$customerId, ':framenumber'=>"", 
            ':child_seat'=>$childSeat, 
            ':comment'=>$comment);
            $sth = Database::getPDO()->prepare("INSERT INTO bike_rental (employee_name, customer_id, framenumber, date_from, date_to, child_seat, status, comment)
            VALUES (:employee_name, :customer_id, :framenumber, :date_from, :date_to, :child_seat, 'reserved', :comment)");
            $sth->execute($params);

            $childSeat--;
        }
    }
}

?>