<?php

declare(strict_types=1);

// Only run logic if form was submitted
if (isset($_POST["register"]))
{
    if (!isset($_POST["name"]) || $_POST["name"] === "")
    {
        $_SESSION["register-name-error"] = "Username can't be empty :(";
    }

    $_SESSION["register-name"] =  $_POST["name"];

    if (!isset($_POST["password"]) || $_POST["password"] === "")
    {
        $_SESSION["register-password-error"] = "Password can't be empty :(";
    }

    if (!isset($_POST["re-password"]) || $_POST["re-password"] === "")
    {
        $_SESSION["register-re-password-error"] = "Repeat Password can't be empty :(";
    }

    if (isset($_SESSION["login-name-error"]) || isset($_SESSION["login-password-error"]) || isset($_SESSION["login-re-password-error"]))
    {
        // Reload page to clear POST and stop further execution
        header("Location: ?" . http_build_query($_GET));
        exit;
    }

    if ($_POST["password"] !== $_POST["re-password"])
    {
        $_SESSION["register-error"] = "Passwords don't match :(";
        $_SESSION["register-password-error"] = "";
        $_SESSION["register-re-password-error"] = "";

        header("Location: ?" . http_build_query($_GET));
        exit;
    }

    unset($_SESSION["register-name"]);

    if (Employee::exists($_POST["name"]))
    {
        $_SESSION["register-name-error"] = "Username already exists";

        header("Location: ?" . http_build_query($_GET));
        exit;
    }

    Employee::register($_POST["name"], $_POST["password"]);

    header("Location: ?" . http_build_query($_GET));
    exit;
}

?>
<form method="POST" onsubmit="return validateRegisterForm()">
    <header>Register</header>

    <!-- Only create the element for storing the error if there is one -->
    <?php if (isset($_SESSION["register-error"])) : ?>
        <span class="error"><?= $_SESSION["register-error"] ?></span>
    <?php endif ?>

    <label>
        <header>
            <h3>Username</h3>
            <span id="register-name-error" class="error">
                <?= $_SESSION["register-name-error"] ?? "" ?>
            </span>
        </header>
        <input id="register-name" oninput="validateRegisterUsername()" type="text" name="name" value="<?= htmlspecialchars($_SESSION["register-name"] ?? "") ?>" placeholder="Username" autofocus onfocus="this.select()" />
    </label>

    <label>
        <header>
            <h3>Password</h3>
            <span id="register-password-error" class="error">
                <?= $_SESSION["register-password-error"] ?? "" ?>
            </span>
        </header>
        <input id="register-password" oninput="validateRegisterPassword()" type="password" name="password" placeholder="Password" />
    </label>

    <label>
        <header>
            <h3>Repeat Password</h3>
            <span id="register-re-password-error" class="error">
                <?= $_SESSION["register-re-password-error"] ?? "" ?>
            </span>
        </header>
        <input id="register-re-password" oninput="validateRegisterRepeatPassword()" type="password" name="re-password" placeholder="Repeat Password" />
    </label>

    <input class="submit" type="submit" name="register" value="Register" />
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
            nameError.innerHTML = "Username can't be empty";
        } else {
            nameError.innerHTML = "";
        }
    }

    function validateRegisterPassword() {
        if (passwordInput.value === "") {
            passwordError.innerHTML = "Password can't be empty";
        } else {
            passwordError.innerHTML = "";
        }
    }

    function validateRegisterRepeatPassword() {
        if (repeatPasswordInput.value === "") {
            repeatPasswordError.innerHTML = "Repeat password can't be empty";
        } else if (passwordInput.value !== repeatPasswordInput.value) {
            repeatPasswordError.innerHTML = "Passwords don't match";
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