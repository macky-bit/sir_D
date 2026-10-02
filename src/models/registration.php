<?php

function check_existing_email(mysqli $conn, string $email): bool
{
    $statement = $conn->prepare(
        "SELECT id FROM users WHERE email = ? LIMIT 1"
    );

    $statement->bind_param("s", $email);
    $statement->execute();

    $result = $statement->get_result();
    $exists = $result->num_rows > 0;

    $statement->close();

    return $exists;
}

function save_registration(
    mysqli $conn,
    string $name,
    string $email,
    string $password
): array {
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $statement = $conn->prepare(
        "INSERT INTO users (name, email, password, created_at)
         VALUES (?, ?, ?, NOW())"
    );

    $statement->bind_param("sss", $name, $email, $passwordHash);
    $statement->execute();

    $user = [
        "id" => $conn->insert_id,
        "name" => $name,
    ];

    $statement->close();

    return $user;
}
