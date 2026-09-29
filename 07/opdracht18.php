<?php

class VoetbalBelasting
{
    public string $spelerNaam;
    public string $voorkeursPositie;
    public int $weekDist;
    public int $weekIntense;
    public float $weekRPE;

    public function calcAWR(): float
    {
        return (($this->weekDist * $this->weekIntense) / $this->weekRPE)/1000000;
    }
}

class VoetbalCoachInfo extends VoetbalBelasting
{
    public string $playingPosition;
    public int $expectedMinutes;
}

$speler = new VoetbalCoachInfo();

$speler->spelerNaam = "Jan J";
$speler->voorkeursPositie = "CM";
$speler->weekDist = 53653;
$speler->weekIntense = 8674;
$speler->weekRPE = 6.7;

$speler->playingPosition = "SPli";
$speler->expectedMinutes = 65;

echo  $speler->spelerNaam . ": " . $speler->calcAWR() . "<html> <- Dit is zichtbaar voor het belastingsteam.".
 "<br> $speler->expectedMinutes ex min op $speler->playingPosition <- Dit is alleen zichtbaar voor de coachende staff </html>";

?>