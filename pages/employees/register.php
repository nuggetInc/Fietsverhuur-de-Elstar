<?php

declare(strict_types=1);

// Only run logic if form was submitted
if (isset($_POST["register"]))
{
    $_SESSION["register-name"] =  $_POST["name"];
    $_SESSION["register-permission"] =  $_POST["permission"];

    if (!isset($_POST["name"]) || $_POST["name"] === "")
    {
        $_SESSION["register-name-error"] = "Gebruikersnaam kan niet leeg zijn :(";
    }

    if (!isset($_POST["password"]) || $_POST["password"] === "")
    {
        $_SESSION["register-password-error"] = "Wachtwoord kan niet leeg zijn :(";
    }

    if (!isset($_POST["re-password"]) || $_POST["re-password"] === "")
    {
        $_SESSION["register-re-password-error"] = "Herhaal wachtwoord kan niet leeg zijn :(";
    }

    if (!isset($_POST["permission"]) || $_POST["permission"] === "")
    {
        $_SESSION["register-permission-error"] = "Toestemming kan niet leeg zijn :(";
    }

    if (isset($_SESSION["login-name-error"]) || isset($_SESSION["login-password-error"]) || isset($_SESSION["login-re-password-error"]))
    {
        // Reload page to clear POST and stop further execution
        header("Location: $uri");
        exit;
    }

    if ($_POST["password"] !== $_POST["re-password"])
    {
        $_SESSION["register-error"] = "Wachtwoorden zijn niet hetzelfde :(";
        $_SESSION["register-password-error"] = "";
        $_SESSION["register-re-password-error"] = "";

        header("Location: $uri");
        exit;
    }

    unset($_SESSION["register-name"]);

    if (Employee::exists($_POST["name"]))
    {
        $_SESSION["register-name-error"] = "Gebruiker bestaat al";

        header("Location: $uri");
        exit;
    }

    Employee::register($_POST["name"], $_POST["password"], Permission::from($_POST["permission"]));

    unset($_SESSION["register-permission"]);

    header("Location: $uri");
    exit;
}

?>
<form method="POST" onsubmit="return validateRegisterForm()">
    <header>Registreren</header>

    <!-- Only create the element for storing the error if there is one -->
    <?php if (isset($_SESSION["register-error"])) : ?>
        <span class="error"><?= $_SESSION["register-error"] ?></span>
    <?php endif ?>

    <label class="field">
        <header>
            <h3>Gebruikersnaam</h3>
            <span id="register-name-error" class="error">
                <?= $_SESSION["register-name-error"] ?? "" ?>
            </span>
        </header>
        <input id="register-name" oninput="validateRegisterUsername()" type="text" name="name" value="<?= htmlspecialchars($_SESSION["register-name"] ?? "") ?>" placeholder="Gebruikersnaam" autofocus onfocus="this.select()" />
    </label>

    <label class="field">
        <header>
            <h3>Wachtwoord</h3>
            <span id="register-password-error" class="error">
                <?= $_SESSION["register-password-error"] ?? "" ?>
            </span>
        </header>
        <input id="register-password" oninput="validateRegisterPassword()" type="password" name="password" placeholder="Wachtwoord" />
    </label>

    <label class="field">
        <header>
            <h3>Herhaal Wachtwoord</h3>
            <span id="register-re-password-error" class="error">
                <?= $_SESSION["register-re-password-error"] ?? "" ?>
            </span>
        </header>
        <input id="register-re-password" oninput="validateRegisterRepeatPassword()" type="password" name="re-password" placeholder="Herhaal Wachtwoord" />
    </label>

    <div class="field">
        <header>
            <h3>Toestemming</h3>
            <span id="register-permission-error" class="error">
                <?= $_SESSION["register-permission-error"] ?? "" ?>
            </span>
        </header>
        <div class="inline">
            <label>
                <input id="register-admin" type="radio" name="permission" value="user" checked />
                Gebruiker
            </label>
            <label>
                <input id="register-admin" type="radio" name="permission" value="admin" />
                Administrator
            </label>
        </div>
    </div>

    <input type="submit" name="register" value="Registreren" />
</form>
</div>
<script type="text/javascript">
    const nameInput = document.getElementById("register-name");
    const passwordInput = document.getElementById("register-password");
    const repeatPasswordInput = document.getElementById("register-re-password");

    const nameError = document.getElementById("register-name-error");
    const passwordError = document.getElementById("register-password-error");
    const repeatPasswordError = document.getElementById("register-re-password-error");


    /** @return {boolean} */
    function validateRegisterForm() {
        return nameInput.value !== "" && passwordInput.value !== "" && repeatPasswordInput.value !== "" && passwordInput.value == repeatPasswordInput.value;
    }

    function validateRegisterUsername() {
        if (nameInput.value === "") {
            nameError.innerHTML = "Gebruikersnaam kan niet leeg zijn";
        } else {
            nameError.innerHTML = "";
        }
    }

    function validateRegisterPassword() {
        if (passwordInput.value === "") {
            passwordError.innerHTML = "Wachtwoord kan niet leeg zijn";
        } else {
            passwordError.innerHTML = "";
        }
    }

    function validateRegisterRepeatPassword() {
        if (repeatPasswordInput.value === "") {
            repeatPasswordError.innerHTML = "Herhaal wachtwoord kan niet leeg zijn";
        } else if (passwordInput.value !== repeatPasswordInput.value) {
            repeatPasswordError.innerHTML = "Wachtwoorden zijn niet hetzelfde";
        } else {
            repeatPasswordError.innerHTML = "";
        }
    }
</script>
<?php

// We don't want these session variables to bleed into other tabs.
unset($_SESSION["register-name"]);
unset($_SESSION["register-error"]);
unset($_SESSION["register-name-error"]);
unset($_SESSION["register-password-error"]);
unset($_SESSION["register-re-password-error"]);

?>