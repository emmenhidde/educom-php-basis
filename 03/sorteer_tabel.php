<?php
$personen = [
    ["naam" => "Jan de Vries", "adres" => "Kerkstraat 12, Amsterdam"],
    ["naam" => "Sophie Jansen", "adres" => "Dorpsweg 45, Rotterdam"],
    ["naam" => "Mark Peters", "adres" => "Stationsstraat 8, Eindhoven"],
    ["naam" => "Lisa van Dijk", "adres" => "Marktplein 21, Maastricht"],
    ["naam" => "Tom Smit", "adres" => "Molenweg 17, Utrecht"],
    ["naam" => "Emma Bakker", "adres" => "Schoolstraat 33, Tilburg"],
    ["naam" => "Daan Visser", "adres" => "Wilhelminastraat 6, Breda"],
    ["naam" => "Noa Meijer", "adres" => "Beukenlaan 14, Nijmegen"],
    ["naam" => "Lucas Bos", "adres" => "Parkweg 28, Arnhem"],
    ["naam" => "Mila Vos", "adres" => "Lindestraat 9, Sittard"]
];

// Sorting direction (ascending/descending)
$sortingVariable = $_GET['sort'] ?? '';
$sortingOrder = $_GET['order'] ?? 'asc';

if ($sortingVariable == 'naam' || $sortingVariable == 'adres') {

    usort(
        $personen,
        function ($a, $b) use ($sortingVariable, $sortingOrder) {

            if ($sortingOrder == 'asc') {
                return strcmp($a[$sortingVariable], $b[$sortingVariable]);
            } else {
                return strcmp($b[$sortingVariable], $a[$sortingVariable]);
            }
        }
    );
}
// Sorting direction button logic
$naamOrder = ($sortingVariable == 'naam' && $sortingOrder == 'asc') ? 'desc' : 'asc';
$adresOrder = ($sortingVariable == 'adres' && $sortingOrder == 'asc') ? 'desc' : 'asc';

// Changing Table Header to show sorting direction
$naamHeader = "Naam";
$adresHeader = "Adres";

if ($sortingVariable == "naam") {
    if ($sortingOrder == "asc") {
        $naamHeader .= " ↓";
    } else {
        $naamHeader .= " ↑";
    }
}

if ($sortingVariable == "adres") {
    if ($sortingOrder == "asc") {
        $adresHeader .= " ↓";
    } else {
        $adresHeader .= " ↑";
    }
}

echo "<a href='?sort=naam&order=$naamOrder'>
        <button>Sorteer op naam</button>
      </a>";

echo "<a href='?sort=adres&order=$adresOrder'>
        <button>Sorteer op adres</button>
      </a>";

echo "<table>";
echo "<tr>";
echo "<th>" . $naamHeader . "</th>";
echo "<th>" . $adresHeader . "</th>";
echo "</tr>";
foreach ($personen as $persoon) {
    echo "<tr>";
    echo "<td>" . $persoon['naam'] . "</td>";
    echo "<td>" . $persoon['adres'] . "</td>";
    echo "</tr>";
}
?>