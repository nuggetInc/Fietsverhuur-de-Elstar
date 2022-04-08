<?php  

declare(strict_types=1);

$reserverTable = new ReserverTable();

$datesAndPeopleBool = false;

$_SESSION["customerError"] = false;
if (isset($_POST["customerId"]))
{
    if(is_numeric($_POST["customerId"]))
    { 
        if($customer = Customer::getcustomer(intval($_POST["customerId"])))
        {
            $_SESSION["displayCustomer"] =  $customer->getName() . " " . $customer->getSurname();
            $_SESSION["customerId"] = $_POST["customerId"];   
        }
        else
        {
            $_SESSION["customerError"] = true;
        }
    }
    $datesAndPeopleBool = isset($_POST["numberOfPeople"]) && isset($_POST["dateFrom"]) && isset($_POST["dateTo"]);
}
else
{
    $_SESSION["displayCustomer"] = "";
    $_SESSION["dates"] = "";
}


if($datesAndPeopleBool)
{
    $_SESSION["dates"] = array("dateTo"=>$_POST["dateTo"], "dateFrom"=>$_POST["dateFrom"]);
    $_SESSION["numberOfPeople"] = $_POST["numberOfPeople"];
    $reserverTable->setDates($_SESSION["dates"]);
    $reserverTable->setWeekCount(2);
    

}
else
{
    $_SESSION["numberOfPeople"] = "";
    $_SESSION["dates"] = array("dateTo"=>"", "dateFrom"=>"");
}


if(isset($_POST["createReserve"]) && !isset($_SESSION["succes"]))
{
    echo $_POST["createReserve"];

    $bikeRental = new BikeRental();
    $bikeRental->setDates($_SESSION["dates"]);
    $bikeRental->setCustomerId($_SESSION["customerId"]);
    $bikeRental->setNumberOfPeople($_SESSION["numberOfPeople"]);

    $bikeRental->setChildSeat(isset($_POST["childSeat"]) ? 1 : 0);
    $bikeRental->setComment($_POST["comment"]);
    $bikeRental->addReserve($_SESSION["user"]->getName());


    //new page----------------------------------------------
    $_SESSION["succes"] = true;
}

if(isset($_SESSION["succes"]))
{
    unset($_SESSION["succes"]); 
    $_POST["createReserve"] = null;
    $_POST["customerId"] = null;
    $datesAndPeopleBool = false;
}
?>

<?php if(isset($_SESSION["succes"])) : ?>
    <h3 style="color: green;">Reservering voor <?= $_SESSION["numberOfPeople"] ?> personen is aan gemaakt. <br>
    van: <?= $_SESSION["dates"]["dateFrom"]?> tot: <?= $_SESSION["dates"]["dateTo"]?></h3>
<?php endif ?>

<form action="" method="POST">
    <header>Nieuwe reservering</header> 
    <label class="field">
        <?php if(isset($_POST["customerId"])) : ?>
            <header><h3>Klant</h3></header>
        <?php else: ?>
            <header><h3>Klant id</h3></header>
        <?php endif ?>
        <input  type="text" name="customerId" value="<?= $_SESSION["displayCustomer"] ?>" placeholder="Klant id" required>
    </label>
        <?php if($_SESSION["customerError"]) : ?>
        <p style="color: red">Klant bestaat niet</p>
        <?php endif ?>

    <?php if(isset($_POST["customerId"]) && !$_SESSION["customerError"]) : ?>
        <label  class="field">
            <header><h3>Aantal personen/fietsen</h3></header>
            <input type="number" name="numberOfPeople" value="<?= $_SESSION["numberOfPeople"] ?>" placeholder="Aantal personen/fietsen " required>
        </label>
        <label  class="field">
            <header><h3>Datum vanaf</h3></header>
            <input type="date" name="dateFrom" value="<?= $_SESSION["dates"]["dateFrom"] ?>" required>
        </label>
        <label  class="field">
            <header><h3>Datum tot</h3></header>
            <input type="date" name="dateTo" value="<?= $_SESSION["dates"]["dateTo"] ?>" required>
        </label>
    <?php endif ?>

    <?php if($datesAndPeopleBool) : ?>
        <label  class="field">
            <header><h3>Opmerking</h3></header>

            <textarea name="comment"></textarea>
        </label>
        <label class="field">
            <header><h3>Kinderzitje</h3></header>
            <input type="number" name="childSeat" min="0" max=<?= $_SESSION["displayCustomer"] ?>> 
        </label>
        
    <?php endif ?>
        
    <?php if(!$datesAndPeopleBool && !isset($_SESSION["succes"])) : ?>
        <input type="submit" value="Volgende">
    <?php else: ?>
        <input type="submit" name="createReserve" value="Reserveringen toevoegen">
    <?php endif ?>
</form> 
<?php if($datesAndPeopleBool) { echo $reserverTable->getTable(); } ?>
