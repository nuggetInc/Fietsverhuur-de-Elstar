<?php

declare(strict_types=1);

if (isset($_POST["delete"]))
{
    $_SESSION["match"] = $_POST["match"];
    $_SESSION["customer-id"] = $_POST["customer-id"];
    Customer::delete(intval($_POST["customer-id"]));

    header("Location: $uri");
    exit;
}

if (isset($_POST["match"], $_POST["customer-id"]))
{
    $_SESSION["match"] = $_POST["match"];
    $_SESSION["customer-id"] = $_POST["customer-id"];

    header("Location: $uri");
    exit;
}

$match = "%";
if (isset($_SESSION["match"]))
{
    $match .= $_SESSION["match"] . "%";
}

$customers = Customer::like($match);
if (count($customers) > 0)
{
    if (array_key_exists(intval(@$_SESSION["customer-id"]), $customers))
        $customer = $customers[intval($_SESSION["customer-id"])];
    else
        $customer = $customers[key($customers)];
}

?>
<form method="POST" onchange="this.submit()">
    <header>Verwijderen</header>

    <label class="field">
        <header>
            <h3>Zoeken</h3>
        </header>
        <input type="text" name="match" value="<?= htmlspecialchars($_SESSION["match"] ?? "") ?>" placeholder="1234AB" autofocus onfocus="this.select()" />
    </label>

    <?php if (count($customers) > 0) : ?>
        <label class="field">
            <header>
                <h3>Klant</h3>
            </header>

            <select name="customer-id">
                <?php foreach ($customers as $item) : ?>
                    <?php if (isset($_SESSION["customer-id"]) && intval($_SESSION["customer-id"]) === $item->getId()) : ?>
                        <option value="<?= $item->getId() ?>" selected><?= htmlspecialchars($item->getFullName()) ?></option>
                    <?php else : ?>
                        <option value="<?= $item->getId() ?>"><?= htmlspecialchars($item->getFullName()) ?></option>
                    <?php endif ?>
                <?php endforeach ?>
            </select>
        </label>
    <?php endif ?>

    <input type="submit" name="search" value="Zoeken" />
</form>
<?php if (isset($customer)) : ?>
    <form method="POST">
        <input type="hidden" name="match" value="<?= htmlspecialchars($_SESSION["match"] ?? "") ?>" />
        <input type="hidden" name="customer-id" value="<?= htmlspecialchars($_SESSION["customer-id"] ?? "") ?>" />

        <input type="submit" name="delete" value="Verwijderen" />
    </form>
<?php endif ?>
<?php

unset($_SESSION["match"]);
unset($_SESSION["customer-id"]);

?>