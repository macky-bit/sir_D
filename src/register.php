<?php

require_once __DIR__ . "/session.php";
require_once __DIR__ . "/db/db.php";
require_once __DIR__ . "/models/registration.php";

if (isset($_SESSION["id"])) {
    header("Location: /account");
    exit;
}

$errors = [];
$name = "";
$email = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";
    $confirmPassword = $_POST["confirm_password"] ?? "";

    if ($name === "") {
        $errors[] = "Name is required.";
    }

    if ($email === "") {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Enter a valid email address.";
    }

    if ($password === "") {
        $errors[] = "Password is required.";
    } elseif (strlen($password) < 8) {
        $errors[] = "Password must contain at least 8 characters.";
    }

    if ($password !== $confirmPassword) {
        $errors[] = "You must confirm your password.";
    }

    if (empty($errors) && check_existing_email($conn, $email)) {
        $errors[] = "Email address already exists.";
    }

    if (empty($errors)) {
        $user = save_registration($conn, $name, $email, $password);

        session_regenerate_id(true);
        $_SESSION["id"] = $user["id"];
        $_SESSION["name"] = $user["name"];

        header("Location: /account");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Food Festive</title>
</head>
<body>
    <h1>Sign up to your account</h1>

    <?php if (!empty($errors)): ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error, ENT_QUOTES, "UTF-8") ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="post" action="/register">
        <label for="name">Name:</label>
        <input
            id="name"
            type="text"
            name="name"
            value="<?= htmlspecialchars($name, ENT_QUOTES, "UTF-8") ?>"
        >

        <label for="email">Email:</label>
        <input
            id="email"
            type="email"
            name="email"
            value="<?= htmlspecialchars($email, ENT_QUOTES, "UTF-8") ?>"
        >

        <label for="password">Password:</label>
        <input id="password" type="password" name="password">

        <label for="confirm_password">Confirm Password:</label>
        <input
            id="confirm_password"
            type="password"
            name="confirm_password"
        >

        <button type="submit">Register</button>
    </form>

    <p>Already registered? <a href="/login">Log in</a></p>
</body>
</html>
