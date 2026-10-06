Het verschil zit hem in het gebruik van de manier hoe de Person class gegevens uit de database haalt. Daarvoor heeft de class een databaseverbinding nodig, welke op verschillende manieren en plekken kan worden opgezet.

1. Via een globale variabele
In 'dbconnect_via_global.php' haalt Person de verbinding op met global $db_handle.
Zo wordt de Person class afhankelijk van een variabele van buiten de class. Maar je ziet die afhankelijkheid niet duidelijk aan de constructor, waar deze niet in binnenkomt.

2. Ophalen in de constructor instance
In 'dbconnect_via_constructor_instance.php' bevind de verbinding zich in de constructor.
Doordat DBConnect::getInstance() zich in de class bevindt zijn de class voor DBconnect en Person hard in elkaar verbonden. Een andere verbinding gebruiken is daardoor lastiger.

3. Verbonden via dependency injection
In 'dbconnect_via_dependency_injection.php' krijgt Person de verbinding via de constructor binnen.
Zo heeft de Person class deze verbinding niet zelf, maar wordt deze van buitenaf meegegeven. Zo is ook duidelijker wat Person nodig heeft.
De DI krijgt daarmee het beste van de 2 andere opties.
Doordat de Person class deze wel via constructor ontvangt, maar deze er niet in vast zet is de code beter interpreteerbaar en beter als losse class te implementeren.