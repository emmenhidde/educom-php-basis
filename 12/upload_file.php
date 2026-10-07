<?php


if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['file'])) {
    exit('Kies eerst een bestand.');
}

$bestandUpload = $_FILES['file'];

$map = __DIR__ . '/upload/';


if ($bestandUpload['size'] > 1 * 1024 * 1024) {
    exit('Het bestand mag maximaal 1 MB zijn.');
}

$afbeeldingFileInfo = getimagesize($bestandUpload['tmp_name']);
$extensie = strtolower(pathinfo($bestandUpload['name'], PATHINFO_EXTENSION));
$toegestaneTypes = [
    'jpg' => 'image/jpeg',
    'jpeg' =>'image/jpeg',
    'png' => 'image/png',
    'gif' => 'image/gif',
];

if (
    !isset($toegestaneTypes[$extensie]) ||
    $afbeeldingFileInfo['mime'] !== $toegestaneTypes[$extensie]
) {
    exit('Kies een JPG-, PNG- of GIF-afbeelding.');
}


$naam = pathinfo(basename($bestandUpload['name']), PATHINFO_FILENAME);
$pad = $map . $naam . '.' . $extensie;
$nummer = 1;

while (file_exists($pad)) {
    $pad = $map . $naam . '_' . $nummer . '.' . $extensie;
    $nummer++;
}

if (move_uploaded_file($bestandUpload['tmp_name'], $pad)) {
    echo 'Bestand geüpload.';
} else {
    echo 'Het uploaden is mislukt.';
}
