Betreffende:

``name=_GET['name'];`` 
``$sql = "SELECT * FROM person WHERE first_name = $name";``

1. Waarom deze query gevaarlijk is als \$name geen gewone naam is, maar SQL?
\$name komt door de _GET uit de URL.
Zo wordt deze die invoer in SQL doorgevoerd.
Wat in wordt gevoerd kan daarmee SQL-syntax worden.

2. Wat er op een testdb mis kan gaan (meer rijen dan bedoeld, of de zoekfilter valt weg)?
Door bijvoorbeeld `OR 1=1` in te voeren, wordt de zoekfilter altijd waar.
Zo worden er meer rijen uit de testdb getoond dan bedoeld.

3. Hoe een prepared statement (placeholder ? of :naam + bind) dat voorkomt?
door SQL Querry binnen `prepare()` te zetten wordt \$name als waarde behandeld.
Daarmee werkt de invoer niet langer als syntax.
