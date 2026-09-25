<?php

function show_header(){
    echo "
    <!DOCTYPE html>
    <html lang='en'>

    <head>
        <meta charset='UTF-8'>
        <title>AI History</title>

        <style>
            body {
                font-family: Arial;
                margin: 20px;
            }

            header, nav, footer {
                padding: 10px;
                background-color: #eeeeeee1;
            }

            nav a {
                margin-right: 15px;
            }

            main {
                padding: 20px 0;
            }
        </style>
    </head>

    <body>

    <header>
        <b>AI History</b>
    </header>

    <nav>
    <a href='?page=home'>Home</a>
    <a href='?page=ai'>Het begin van AI</a>
    <a href='?page=turingmachine'>Turingmachine</a>
    <a href='?page=turingtest'>Turingtest</a>
    </nav>
    ";
}


function show_content(){

    $page = $_GET['page'] ?? 'home';

    echo "<main>";

    switch ($page) {

        case 'home':
            echo "
            <h2>Home</h2>

            <p>
                Welkom op de homepage om verschillende onderdelen van HTML te laten zien.<br>
                Geniet daarnaast van wat geschiedenis en concepten rondom AI.
            </p>
            ";
            break;


        case 'ai':
            echo "
            <h2>Het begin van AI</h2>

            <p>
                De term kunstmatige intelligentie werd in 1956 geïntroduceerd
                door John McCarthy tijdens de Dartmouth-workshop. <br>
                Dit was een zomerkamp van 8 weken voor onderzoekers die geïnteresseerd waren 
                in het idee dat machines intelligent gedrag konden vertonen.<br>
                Dit is het begin van de definitie kunstmatige intelligentie, ofwel AI.<br>
                Het idee was dat onderdelen van menselijke intelligentie, zoals leren en
                problemen oplossen, mogelijk nauwkeurig genoeg beschreven konden
                worden om door een computer te worden nagebootst.
            </p>
            ";
            break;


        case 'turingmachine':
            echo "
            <h2>De Turingmachine</h2>

            <p>
                Alan Turing introduceerde in 1936 het concept van de Turingmachine.<br>
                Dit is een theoretische machine met een band die oneindig ver naar
                links en rechts kan doorlopen.<br> De machine kan symbolen lezen en
                schrijven en volgens een reeks regels naar links of rechts bewegen.<br>
                Het belangrijkste idee is dat iedere berekening die als algoritme
                beschreven kan worden, in principe door zo'n machine uitgevoerd
                kan worden.
            </p>
            ";
            break;


        case 'turingtest':
            echo "
            <h2>De Turingtest</h2>

            <p>
                De Turingtest werd in 1950 voorgesteld door Alan Turing.<br>
                Bij deze test communiceert een persoon met zowel een andere persoon
                als een machine, zonder te kunnen zien wie wie is.<br> Als de persoon
                niet betrouwbaar kan bepalen welke van de twee de machine is,
                zou de machine intelligent gedrag kunnen vertonen.<br> Naarmate AI
                beter wordt, verschuift ook de discussie over wat voldoende is
                om een systeem als intelligent te beschouwen.
            </p>
            ";
            break;
    }

    echo "</main>";
}


function show_footer(){
    echo "
    <footer>
        <i>This is the footer -AI History</i>
    </footer>

    </body>
    </html>
    ";
}

?>