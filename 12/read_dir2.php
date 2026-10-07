<?php

$directoryInput = 'C:/xampp/htdocs/educom_php/educom-php-basis/12';

function readDirectory($directory, $level = 0)
{
    if ($handle = opendir($directory)) {
        while (false !== ($entry = readdir($handle))) {
            if ($entry == "." || $entry == "..") {
                continue;
            }

            echo str_repeat("\t", $level) . $entry . "\n";

            if (is_dir($directory . "/" . $entry)) {
                readDirectory($directory . "/" . $entry, $level + 1);
            }
        }

        closedir($handle);
    }
}

echo "<b>Entries:</b><pre>";
readDirectory($directoryInput);
echo "</pre>";
?>