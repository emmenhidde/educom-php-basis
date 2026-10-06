<?php

class User
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function getUser(string $username, string $password): ?object
    {
        $statement = $this->connection->prepare(
            'SELECT * FROM Users WHERE username = :username AND passwords = :password'
        );
        $statement->execute([
            'username' => $username,
            'password' => $password,
        ]);

        $user = $statement->fetch(PDO::FETCH_OBJ);

        return $user === false ? null : $user;
    }

    public function insert(string $username, string $password): bool
    {
        $statement = $this->connection->prepare(
            'INSERT INTO Users (username, passwords) VALUES (:username, :password)'
        );

        return $statement->execute([
            'username' => $username,
            'password' => $password,
        ]);
    }

    public function showUser(): void
    {
        $statement = $this->connection->prepare(
            'SELECT naam, leeftijd, geboorteplaats, geboortedatum FROM userTable11'
        );
        $statement->execute();

        foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $person) {
            echo htmlspecialchars((string) $person['naam'], ENT_QUOTES, 'UTF-8')
                . ' - ' . htmlspecialchars((string) $person['leeftijd'], ENT_QUOTES, 'UTF-8')
                . ' - ' . htmlspecialchars((string) $person['geboorteplaats'], ENT_QUOTES, 'UTF-8')
                . ' - ' . htmlspecialchars((string) $person['geboortedatum'], ENT_QUOTES, 'UTF-8')
                . '<br>';
        }
    }
}
?>