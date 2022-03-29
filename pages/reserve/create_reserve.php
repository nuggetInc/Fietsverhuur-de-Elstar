<?php  

declare(strict_types=1);

$customer = new Customer();
$reserverTable = new ReserverTable();

$_SESSION["customerError"] = false;
if (isset($_POST["customerId"]))
{
    if(is_numeric($_POST["customerId"]))
    { 
        if($customer->setCustomerId(intval($_POST["customerId"])))
        {
            $_SESSION["displayCustomer"] =  $customer->getCustomerById()["name"] . " " . $customer->getCustomerById()["surname"];
        }
        else
        {
            $_SESSION["customerError"] = true;
        }
    }
    
}
else
{
    $_SESSION["displayCustomer"] = "";
    $_SESSION["dates"] = "";
}
$datesAndPeopleBool = isset($_POST["numberOfPeople"]) && isset($_POST["dateFrom"]) && isset($_POST["dateTo"]);

if($datesAndPeopleBool)
{
    $_SESSION["dates"] = array("dateTo"=>$_POST["dateTo"], "dateFrom"=>$_POST["dateFrom"]);
    $_SESSION["numberOfPeople"] = $_POST["numberOfPeople"];
    $reserverTable->setDates($_SESSION["dates"]);
    $reserverTable->setWeekCount(2);
    

}


?>


<form action="" method="POST">
    <header>Nieuwe reservering</header> 
    <?php if(isset($_POST["customerId"])) : ?>
        <label>Klant</label>
    <?php else: ?>
        <label>Klant id</label>
    <?php endif ?>
    <input  type="text" name="customerId" value="<?= $_SESSION["displayCustomer"] ?>" placeholder="Klant id" required>
        <?php if($_SESSION["customerError"]) : ?>
        <p style="color: red">Klant bestaat niet</p>
        <?php endif ?>

    <?php if(isset($_POST["customerId"]) && !$_SESSION["customerError"]) : ?>
        <label>Aantal personen/fietsen</label>
        <input type="number" name="numberOfPeople" placeholder="Aantal personen/fietsen " required>
        <label>Datum vanaf</label>
        <input type="date" name="dateFrom" required>
        <label>Datum tot</label>
        <input type="date" name="dateTo" required>
    <?php endif ?>
    

    <input type="submit">
</form> 

<?php if($datesAndPeopleBool) { echo $reserverTable->getTable(); } ?>