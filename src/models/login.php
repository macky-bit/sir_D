<?php

function login_account(
    mysqli $conn,
    string $email,
    string $password
): array {
    $statement = $conn->prepare(
        "SELECT id, name, password
         FROM users
         WHERE email = ?
         LIMIT 1"
    );

    $statement->bind_param("s", $email);
    $statement->execute();

    $result = $statement->get_result();
    $userRecord = $result->fetch_assoc();

    $statement->close();

    if (
        !$userRecord ||
        !password_verify($password, $userRecord["password"])
    ) {
        return [];
    }

    return [
        "id" => $userRecord["id"],
        "name" => $userRecord["name"],
    ];
}
