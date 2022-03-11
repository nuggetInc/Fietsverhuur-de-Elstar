<?php

declare(strict_types=1);

if (isset($_POST["employees"]))
{
    $_SESSION["employee-search"] = $_POST["search"];

    header("Location: ?" . http_build_query($_GET));
    exit;
}

?>
<form id="employees" method="POST">
    <h1>Search</h1>

    <label>
        <span class="label">
            <h3>Search</h3>
        </span>
        <input type="text" name="search" value="<?= htmlspecialchars($_SESSION["employee-search"]) ?>" placeholder="Search" autofocus onfocus="this.select()" />
    </label>

    <input type="submit" name="employees" value="Search" />
</form>
<?php if (isset($_SESSION["employee-search"])) : ?>
    <?php foreach ($database->getEmployeesLike($_SESSION["employee-search"]) as $employee) : ?>
        <p><?= $employee->getId() ?> <?= $employee->getName() ?> <?= $employee->getPermission()->value ?></p>
    <?php endforeach ?>
<?php endif ?>