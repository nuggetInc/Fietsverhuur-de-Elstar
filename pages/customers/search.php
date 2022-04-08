<?php

declare(strict_types=1);

if (isset($_POST["update"]))
{
    $_SESSION["match"] = $_POST["match"];
    $_SESSION["customer-id"] = intval($_POST["customer-id"]);

    $_SESSION["salutation"] = $_POST["salutation"];
    $_SESSION["name"] = $_POST["name"];
    $_SESSION["surname"] = $_POST["surname"];
    $_SESSION["email"] = $_POST["email"];
    $_SESSION["phonenumber"] = $_POST["phonenumber"];
    $_SESSION["postalcode"] = $_POST["postalcode"];

    Customer::update(intval($_POST["customer-id"]), $_POST["salutation"], $_POST["name"], $_POST["surname"], $_POST["email"], $_POST["phonenumber"], $_POST["postalcode"]);

    header("Location: $uri");
    exit;
}

if (isset($_POST["match"], $_POST["customer-id"]))
{
    $_SESSION["match"] = $_POST["match"];
    $_SESSION["customer-id"] = intval($_POST["customer-id"]);

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
    if (array_key_exists(@$_SESSION["customer-id"], $customers))
        $customer = $customers[$_SESSION["customer-id"]];
    else
        $customer = $customers[key($customers)];
}

?>
<form method="POST" onchange="this.submit()">
    <header>Zoeken</header>

    <label class="field">
        <header>
            <h3>Zoeken</h3>
        </header>
        <input type="text" name="match" value="<?= htmlspecialchars($_SESSION["match"] ?? "") ?>" placeholder="Zoeken" autofocus onfocus="this.select()" />
    </label>

    <?php if (count($customers) > 0) : ?>
        <label class="field">
            <header>
                <h3>Klant</h3>
            </header>

            <select name="customer-id">
                <?php foreach ($customers as $item) : ?>
                    <?php if (isset($_SESSION["customer-id"]) && $_SESSION["customer-id"] === $item->getId()) : ?>
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
        <header>Aanpassen</header>

        <input type="hidden" name="match" value="<?= htmlspecialchars($_SESSION["match"] ?? "") ?>" />
        <input type="hidden" name="customer-id" value="<?= @$_SESSION["customer-id"] ?>" />

        <label class="field">
            <header>
                <h3>Salutation</h3>
            </header>
            <input type="text" name="salutation" value="<?= htmlspecialchars($customer->getSalutation()) ?>" />
        </label>

        <label class="field">
            <header>
                <h3>Voornaam</h3>
            </header>
            <input type="text" name="name" value="<?= htmlspecialchars($customer->getName()) ?>" />
        </label>

        <label class="field">
            <header>
                <h3>Achternaam</h3>
            </header>
            <input type="text" name="surname" value="<?= htmlspecialchars($customer->getSurname()) ?>" />
        </label>

        <label class="field">
            <header>
                <h3>E-Mail</h3>
            </header>
            <input type="text" name="email" value="<?= htmlspecialchars($customer->getEmail()) ?>" />
        </label>

        <label class="field">
            <header>
                <h3>Telefoonnummer</h3>
            </header>
            <input type="text" name="phonenumber" value="<?= htmlspecialchars($customer->getPhonenumber()) ?>" />
        </label>

        <label class="field">
            <header>
                <h3>Postcode</h3>
            </header>
            <input type="text" name="postalcode" value="<?= htmlspecialchars($customer->getPostalcode()) ?>" />
        </label>

        <input type="submit" name="update" value="Aanpassen" />
    </form>
<?php endif ?>
<?php

unset($_SESSION["match"]);
unset($_SESSION["customer-id"]);

?>