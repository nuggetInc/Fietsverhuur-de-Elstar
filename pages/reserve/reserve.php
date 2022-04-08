<?php

declare(strict_types=1);

$reserveTabel = new ReserverTable();

if(isset($_POST["startDate"]))
{
    $reserveTabel->setDates(array("dateFrom"=>$_POST["startDate"], "dateTo"=>date("Y-m-d", strtotime($_POST["startDate"] . "+21 days"))));
}
$reserveTabel->setWeekCount(4);
?>

<form method="POST" action="">
    <header>Datum</header>
    <input type="date" name="startDate">
    <input type="submit">
</form>

<?= $reserveTabel->getTable(); ?>
<?php if (isset($_GET["dayInfo"])) : ?>

    <table>
        <tr>
            <th>Medewerker</th>
            <th>Klant</th>
            <th>Fiets</th>
            <th>Datum vanaf</th>
            <th>Datum Tot</th>
            <th>Kinderzitje</th>
            <th>Status</th>
            <th>Opmerking</th>
        </tr>
        <?php
        $customer = new Customer();
        $bikeRental = new BikeRental();
        $bikeRental->setStatus(0);
        $bikeRental->setDate(date("Y-m-d", strtotime($_GET["dayInfo"])));
        $getDate = $bikeRental->getDate();

        for ($i = 0; $i < count($getDate); $i++)
        {
            echo "<tr>";
            $customer->setCustomerId($getDate[$i]["customer_id"]);
            for ($j = 1; $j < (count($getDate[$i]) / 2); $j++)
            {
                $displayText = $getDate[$i][$j];
                switch ($j)
                {
                    case 2:
                        $displayText = $customer->getCustomerById()["name"];
                        break;
                    case 6:
                        $displayText = $displayText == 0 ? "Nee" : "Ja";
                        break;
                }

                echo "<td>{$displayText}</td>";
            }
            echo "</tr>";
        }
        ?>
    </table>
    <a href="?page=reserve"><button class="back-button">Terug</button></a>

<?php endif ?>