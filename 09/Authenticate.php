<?php

function findUser(mysqli $database, string $username): array|false
{
    $query = $database->prepare(
        'SELECT username, password_hash FROM users WHERE username = ?'
    );
    $query->bind_param('s', $username);
    $query->execute();
    $user = $query->get_result()->fetch_assoc();
    $query->close();

    return $user ?: false;
}

function validPassword(string $password): bool
{
    return preg_match('/\A[A-Za-z0-9]{6,15}\z/', $password) === 1;
}

function validUsername(string $username): bool
{
    return preg_match('/\A[A-Za-z]{1,50}\z/', $username) === 1;
}

function registerUser(mysqli $database, string $username, string $password): bool
{
    if (!validUsername($username) || !validPassword($password) || findUser($database, $username)) {
        return false;
    }

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $query = $database->prepare(
        'INSERT INTO users (username, password_hash) VALUES (?, ?)'
    );
    $query->bind_param('ss', $username, $passwordHash);
    $created = $query->execute();
    $query->close();

    return $created;
}

