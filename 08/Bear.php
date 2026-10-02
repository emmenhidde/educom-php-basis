<?php

class Bear
{
    public string $name;
    public string $habitat;

    public function __construct(string $name, string $habitat)
    {
        $this->name = $name;
        $this->habitat = $habitat;
    }

    public function __toString(): string
    {
        return 'Bear: ' .$this->name . ' <br>leefgebied: ' . $this->habitat;
    }
}

class Grizzly extends Bear
{
    public function roars(): bool
    {
        return true;
    }

    public function __toString(): string
    {
        return parent::__toString()
            . '<br>brult: ' . ($this->roars() ? 'ja' : 'nee');
    }
}

$bear = new Bear('Baloe', 'bos');
$grizzly = new Grizzly('Bruno', 'bergen');

echo $bear . "<br><br>" ;
echo $grizzly . "<br><br><br>";

echo "Dit is een var_dump:<br>";
var_dump($bear);
echo "<br>";
var_dump($grizzly);

?>