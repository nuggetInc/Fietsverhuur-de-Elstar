<?php  

declare(strict_types=1);

$customer = new Customer();
$reserverTable = new ReserverTable();


if (isset($_POST["customerId"]))
{
    if(is_numeric($_POST["customerId"]))
    { 
        $customer->setCustomerId(intval($_POST["customerId"])); 
        $_SESSION["displayCustomer"] =  $customer->getCustomerById()["name"] . " " . $customer->getCustomerById()["surname"];
    }
}
else
{
    $_SESSION["displayCustomer"] = "";
}

if(isset($_POST["numberOfPeople"]))
{
    $reserverTable->setWeekCount(1);
    if(!isset($_GET["weekFurther"]) || !isset($_GET["weekBack"]))
    {
        $reserverTable->setStartDate("05-04-2022");
    }
    else
    {
        $date = isset($_GET["weekFurther"]) 
        ? date("d-m-Y", strtotime($_GET["weekFurther"] . "+7days")) 
        : date("d-m-Y", strtotime($_GET["weekBack"] . "-7days"));

        $reserverTable->setStartDate($date);
        $_GET["weekFurther"] = $date;
        $_GET["weekBack"] = $date;
    }
    
    $reserverTable->setButtonText("Dag selecteren");
    $reserverTable->setButtonLink("?page=create_reserve");
    $_SESSION["numberOfPeople"] = $_POST["numberOfPeople"];
}
//else {$_SESSION["numberOfPeople"] = "";}
?>


<form action="" method="POST">
    <header>Nieuwe reservering</header> 
    <?php if(isset($_POST["customerId"])) : ?>
        <label>Klant</label>
    <?php else: ?>
        <label>Klant id</label>
    <?php endif ?>
    <input  type="text" name="customerId" value="<?= $_SESSION["displayCustomer"] ?>" placeholder="Klant id">

    <?php if(isset($_POST["customerId"])) : ?>
        <label>Aantal personen/fietsen</label>
        <input type="number" name="numberOfPeople" value="<?= $_SESSION["numberOfPeople"] ?>" placeholder="Aantal personen/fietsen ">
    <?php endif ?>
    <input type="submit">
</form> 
    <?php if(isset($_POST["numberOfPeople"])) : ?>
        <?= $reserverTable->getTable(); ?>  
    <?php endif ?>
    
<script>
    var clickCount = 1; 
    var firstId;  
    function selectTd(id, date) {
        x = document.getElementById(id);
        if(clickCount <= 2)
        {
           x.classList.add("dayselected");
        }
        if(clickCount > 1 && clickCount <= 3)
        {
            for(let i = parseInt(firstId.substr(2)); i < parseInt(id.substr(2)) + 1; i++) 
            {
                document.getElementById("td" + i).classList.add("dayselected");
            }
        }
        if(x.classList.contains('dayselected') && clickCount > 2)
        {
            x.classList.remove('dayselected');
        }
        if(clickCount == 1){
            firstId = id;
        }
        clickCount++;
        console.log(x.style.backgroundColor);
    }
    function WeekBack() {
        document.cookie = "changeWeek = test";
    }
    function WeekFuther() {

    }
</script>        
 