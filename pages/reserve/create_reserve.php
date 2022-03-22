<?php 

declare(strict_types=1);

$customer = new Customer();
$displayCustomer = "";
if (isset($_POST["customer"]) && is_numeric($_POST["customer"]))
{
    $customer->setCustomerId(intval($_POST["customer"]));
    $displayCustomer = $customer->getCustomerById()["name"] . " " . $customer->getCustomerById()["surname"];
}


?>


<form action="" method="POST">
    <header>Nieuwe reservering</header> 
    <?php if(isset($_POST["customer"])) : ?>
        <label>Klant</label>
    <?php else: ?>
        <label>Klant id</label>
    <?php endif ?>
    <input  type="text" name="customer" value="<?= $displayCustomer ?>" placeholder="Klant id">

    <?php if(isset($_POST["customer"])) : ?>
        <label>Aantal personen/fietsen</label>
        <input type="number" name="numberOfPeople" placeholder="Aantal personen/fietsen ">
    <?php endif ?>

    
    <!-- <label>Datum vanaf</label>
    <input type="date" name="dateForm">   
    <label>Datum tot</label>
    <input type="date" name="dateTo">
    
    <label>Opmerking</label>
    <textarea></textarea>
    <div class="inline">
        <label>Kinderzitje:  <input type="checkbox" name="child_seat"></label>
    </div>
     -->
        
    <input type="submit">
</form>