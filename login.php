<?php

declare(strict_types=1);

// Only run logic if form was submitted
if (isset($_POST["login"]))
{
    if (!isset($_POST["name"]) || $_POST["name"] === "")
    {
        $_SESSION["login-name-error"] = "Gebruikersnaam kan niet leeg zijn :(";
    }

    // Save username value so we're able to restore it after a reload
    $_SESSION["login-name"] =  $_POST["name"];

    if (!isset($_POST["password"]) || $_POST["password"] === "")
    {
        $_SESSION["login-password-error"] = "Wachtwoord kan niet leeg zijn :(";
    }

    if (isset($_SESSION["login-name-error"]) || isset($_SESSION["login-password-error"]))
    {
        // Reload page to clear POST and stop further execution
        header("Location: ?" . http_build_query($_GET));
        exit;
    }

    $user = Employee::fromName($_POST["name"]);
    if (isset($user) && password_verify($_POST["password"], $user->getHash()))
    {
        $_SESSION["user"] = $user;

        unset($_SESSION["login-name"]);

        // Reload page with now logged in user
        header("Location: ?" . http_build_query($_GET));
        exit;
    }

    // Empty strings means that there is an error, but no field specific message
    $_SESSION["login-error"] = "Gebruikersnaam of wachtwoord is incorrect";
    $_SESSION["login-name-error"] =  "";
    $_SESSION["login-password-error"] = "";

    header("Location: ?" . http_build_query($_GET));
    exit;
}

?>
<form method="POST" onsubmit="return validateLoginForm()">
    <header>Inloggen</header>

    <!-- Only create the element for storing the error if there is one -->
    <?php if (isset($_SESSION["login-error"])) : ?>
        <span class="error"><?= $_SESSION["login-error"] ?></span>
    <?php endif ?>

    <label class="field">
        <header>
            <h3>Gebruikersnaam</h3>
            <span id="login-name-error" class="error">
                <?= $_SESSION["login-name-error"] ?? "" ?>
            </span>
        </header>
        <input id="login-name" oninput="validateLoginUsername()" type="text" name="name" value="<?= htmlspecialchars($_SESSION["login-name"] ?? "") ?>" placeholder="Gebruikersnaam" autofocus onfocus="this.select()" />
    </label>

    <label class="field">
        <header>
            <h3>Wachtwoord</h3>
            <span id="login-password-error" class="error">
                <?= $_SESSION["login-password-error"] ?? "" ?>
            </span>
        </header>
        <input id="login-password" oninput="validateLoginPassword()" type="password" name="password" placeholder="Wachtwoord" />
    </label>

    <input type="submit" name="login" value="Inloggen" />
</form>
<script type="text/javascript">
    const nameInput = document.getElementById("login-name");
    const passwordInput = document.getElementById("login-password");

    const nameError = document.getElementById("login-name-error");
    const passwordError = document.getElementById("login-password-error");

    /** @return {boolean} */
    function validateLoginForm() {
        return nameInput.value !== "" && passwordInput.value !== "";
    }

    function validateLoginUsername() {
        if (nameInput.value === "") {
            nameError.innerHTML = "Gebruikersnaam kan niet leeg zijn";
        } else {
            nameError.innerHTML = "";
        }
    }

    function validateLoginPassword() {
        if (passwordInput.value === "") {
            passwordError.innerHTML = "Wachtwoord kan niet leeg zijn";
        } else {
            passwordError.innerHTML = "";
        }
    }
</script>
<?php

// We don't want these session variables to bleed into other tabs.
unset($_SESSION["login-name"]);
unset($_SESSION["login-error"]);
unset($_SESSION["login-name-error"]);
unset($_SESSION["login-password-error"]);

?>