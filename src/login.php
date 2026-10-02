<?php

require_once __DIR__ . "/session.php";
require_once __DIR__ . "/db/db.php";
require_once __DIR__ . "/models/login.php";

if (isset($_SESSION["id"])) {
    header("Location: /account");
    exit;
}

$errors = [];
$email = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($email === "") {
        $errors[] = "Email is required.";
    }

    if ($password === "") {
        $errors[] = "Password is required.";
    }

    if (empty($errors)) {
        $user = login_account($conn, $email, $password);

        if (!empty($user)) {
            session_regenerate_id(true);
            $_SESSION["id"] = $user["id"];
            $_SESSION["name"] = $user["name"];

            header("Location: /account");
            exit;
        }

        $errors[] = "The email or password you entered is incorrect.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Food Festive</title>
</head>
<body>
    <h1>Log in to your account</h1>

    <?php if (!empty($errors)): ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error, ENT_QUOTES, "UTF-8") ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="post" action="/login">
        <label for="email">Email:</label>
        <input
            id="email"
            type="email"
            name="email"
            value="<?= htmlspecialchars($email, ENT_QUOTES, "UTF-8") ?>"
        >

        <label for="password">Password:</label>
        <input id="password" type="password" name="password">

        <button type="submit">Login</button>
    </form>

    <p>No account yet? <a href="/register">Register</a></p>
</body>
</html>
