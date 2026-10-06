<?php

class Person
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function showPerson(): void
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