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
    <label>Klant</label>
    <input  type="text" name="customer" value="<?= $displayCustomer ?>" placeholder="Klant id">
</form>
<form>
    <input type="date" name="date_form">      
    <input type="date" name="date_to">
        
    <input type="submit">
</form>