<?php
declare(strict_types=1);

?>

<table>
    <thead>
        <tr>
            <th>Maandag</th>
            <th>Dinsdag</th>
            <th>Woensdag</th>
            <th>Donderdag</th>
            <th>Vrijdag</th>
            <th>Zaterdag</th>
            <th>Zondag</th>
        </tr>
    </thead>
<?php 


$dateNow = (getdate()["wday"] == 0) ? 6 : getdate()["wday"] - 1;
$date = date('d-m-Y', strtotime("-" . $dateNow . " days"));

for($i = 0; $i < 10; $i++) 
{
    echo"<tr>";
    for($j = 0; $j < 7; $j++) 
    {
        $bikeCount =  BikeRental::getCountByDate($date) . " / " . Bike::getTotalBikeCount();
        echo"<td>{$date}<br>{$bikeCount}</td>";
        $date = date('d-m-Y', strtotime($date . "+1 day"));
    }
    echo"<tr>";
}

?>
</table>