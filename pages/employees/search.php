<?php

declare(strict_types=1);

if (isset($_POST["employees"]))
{
    $_SESSION["employee-search"] = $_POST["search"];

    header("Location: $uri");
    exit;
}

$search = "%";
if (isset($_SESSION["bike-search"]))
{
    $search .= $_SESSION["bike-search"] . "%";
}

?>
<form method="POST">
    <header>Zoeken</header>

    <label class="field">
        <header>
            <h3>Zoeken<h3>
        </header>
        <input type="text" name="search" value="<?= htmlspecialchars($_SESSION["employee-search"] ?? "") ?>" placeholder="Zoeken" autofocus onfocus="this.select()" />
    </label>

    <input type="submit" name="employees" value="Zoeken" />
</form>
<?php foreach (Employee::like($search) as $employee) : ?>
    <div class="employee">
        <header>
            <h3><?= $employee->getName() ?></h3>
            <span>[Permission]</span>
        </header>
    </div>
<?php endforeach ?>
<?php

unset($_SESSION["employee-search"]);

?>