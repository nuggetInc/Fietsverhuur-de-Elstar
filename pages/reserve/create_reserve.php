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
    <label>Klant id</label>
    
    <input  type="text" name="customer" value="<?= $displayCustomer ?>" placeholder="Klant id">
</form>
<form>
    <label>Datum vanaf</label>
    <input type="date" name="dateForm">   
    <label>Datum tot</label>
    <input type="date" name="dateTo">
    <label>Aantal personen</label>
    <input type="number" name="numberOfPeople" placeholder="Aantal personen">
    <div class="inline">
        <label>Kinderzitje:  <input type="checkbox" name="child_seat"></label>
    </div>
    
        
    <input type="submit">
</form>