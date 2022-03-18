<?php

declare(strict_types=1);

if (isset($_POST["add_page"]))
{
    $name = $_POST["name"];
    $parent = $_POST["parent"];
    $display = $_POST["display"];
    $order = $_POST["order"];
    $permission = Permission::from($_POST["permission"]);

    Page::add($name, $parent, $display, $order, $permission);

    header("Location: ?" . http_build_query($_GET));
    exit;
}

?>
<form method="POST">
    <header>Add Page</header>

    <label class="field">
        <header>
            <h3>Name</h3>
        </header>
        <input type="text" name="name" placeholder="name" autofocus onfocus="this.select()" />
    </label>

    <label class="field">
        <header>
            <h3>Parent</h3>
        </header>
        <input type="text" name="parent" placeholder="Parent" />
    </label>

    <label class="field">
        <header>
            <h3>Display</h3>
        </header>
        <input type="text" name="display" placeholder="Display" />
    </label>

    <label class="field">
        <header>
            <h3>Order</h3>
        </header>
        <input type="number" name="order" placeholder="Order" />
    </label>

    <div class="field">
        <header>
            <h3>Permission</h3>
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

    <input type="submit" name="add_page" value="Toevoegen" />
</form>