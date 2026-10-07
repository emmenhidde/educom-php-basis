<?php

$directoryInput = 'C:/xampp/htdocs/educom_php/educom-php-basis/12/upload';

function readDirectory($directory, $relativePath = '')
{
    if ($handle = opendir($directory)) {
        while (false !== ($entry = readdir($handle))) {
            if ($entry == "." || $entry == "..") {
                continue;
            }

            $filePath = $directory . "/" . $entry;
            $fileRelativePath = $relativePath . $entry;

            if (is_dir($filePath)) {
                echo "<h3>" . htmlspecialchars($entry, ENT_QUOTES, 'UTF-8') . "</h3>";
                readDirectory($filePath, $fileRelativePath . "/");
            } else {
                $image = getimagesize($filePath);

                if ($image !== false) {
                    $url = "upload/" . implode("/", array_map('rawurlencode', explode("/", $fileRelativePath)));
                    $name = htmlspecialchars($entry, ENT_QUOTES, 'UTF-8');

                    echo '<p><a href="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '" target="_blank" rel="noopener">';
                    echo '<img src="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '" style="max-width: 150px; max-height: 150px; width: auto; height: auto; object-fit: contain;">';
                    echo '</a><br>' . $name . '<br>';
                    echo $image[0] . ' x ' . $image[1] . ' px<br>';
                    echo htmlspecialchars($image['mime'], ENT_QUOTES, 'UTF-8') . '</p>';
                }
            }
        }

        closedir($handle);
    }
}

echo "<h2>Inhoud van de map upload</h2>";
readDirectory($directoryInput);
?>