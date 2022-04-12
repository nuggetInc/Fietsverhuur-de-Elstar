<?php  

declare(strict_types=1);

if(@$_POST["customerId"]) // Customer ID is Set
{
    $_SESSION["customerName"] = Customer::getCustomer(intval($_POST["customerId"]))->getFullName();
    $_SESSION["customerId"] = $_POST["customerId"];
}

//All forms are filled in.
if(!empty($_SESSION["customerId"]) && isset($_POST["numberOfPeople"]) && isset($_POST["dateFrom"]) && isset($_POST["dateTo"]) && isset($_POST["childSeat"]))
{
    BikeRental::addBikeRental(intval($_POST["numberOfPeople"]), intval($_SESSION["customerId"]), 
    $_POST["dateFrom"], $_POST["dateTo"], intval($_POST["childSeat"]), @$_POST["comment"]);

    unset($_SESSION["customerName"]);
    unset($_SESSION["customerId"]);

    echo "<header style='color: green;'><h3>Reservering aangemaakt voor: {$_POST["numberOfPeople"]} personen. <br>
    van: {$_POST["dateFrom"]} tot: {$_POST["dateTo"]}</h3></header>";
}
?>

<form action="" method="POST" onchange="this.submit()">
    <header>Nieuwe reservering</header> 
    <label class="field">
        <?php if(!@$_SESSION["customerName"]) : ?>
            <header><h3>Klant id *</h3></header>
        <?php else : ?>
            <header><h3>Klant *</h3></header>
        <?php endif ?>
        <input  type="text" name="customerId" value="<?= @$_SESSION["customerName"] ?>" placeholder="Klant id" required>
    </label>
</form>
<form action="" method="POST">
    <?php if(@$_SESSION["customerName"]) : ?>
        <label class="field">
            <header><h3>Aantal personen/fietsen *</h3></header>
            <input type="number" name="numberOfPeople" placeholder="Aantal personen/fietsen" required>
        </label>
        <label class="field">
            <header><h3>Datum vanaf *</h3></header>
            <input type="date" name="dateFrom" placeholder="Datum vanaf" required>
        </label> 
        <label class="field">
            <header><h3>Datum tot *</h3></header>
            <input type="date" name="dateTo" placeholder="Datum vanaf" required>
        </label>
        <label class="field">
            <header><h3>Kinderzitjes *</h3></header>
            <input type="number" name="childSeat" placeholder="Kinderzitjes" required>
        </label>  
        <label class="field">
            <header><h3>Opmerking</h3></header>
            <textarea name="comment" placeholder="Opmerking"></textarea>
        </label>        
    <?php endif ?>
    <?php if(@$_SESSION["customerName"]) : ?>
        <input type="submit" value="Volgende">
    <?php endif ?>
</form>