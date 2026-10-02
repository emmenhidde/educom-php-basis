<?php

require 'classes_webpage.php';

$pagina = new WebPage("Mijn Eerste Pagina");

$pagina->showHeader();
$pagina->showContent("<h1>Header vd website!</h1><br><br><p>Dit is de inhoud van de pagina.</p>");
$pagina->showFooter();


?>