<?php

declare(strict_types=1);

if (isset($_POST["employees"]))
{
    $_SESSION["employee-search"] = $_POST["search"];

    header("Location: $uri");
    exit;
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
<?php if (isset($_SESSION["employee-search"])) : ?>
    <?php foreach (Employee::like("%" . $_SESSION["employee-search"] . "%") as $employee) : ?>
        <p><?= $employee->getName() ?></p>
    <?php endforeach ?>
<?php else : ?>
    <?php foreach (Employee::like("%") as $employee) : ?>
        <div class="employee">
            <header>
                <h3><?= $employee->getName() ?></h3>
                <span>[Permission]</span>
            </header>
        </div>
    <?php endforeach ?>
<?php endif ?>
<?php

unset($_SESSION["employee-search"]);

?>