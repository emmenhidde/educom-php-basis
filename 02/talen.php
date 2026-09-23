<?php

$talen = [
	'PHP',
	'JavaScript',
	'Python',
	'Java',
	'C#',
	'C++',
	'Ruby',
    'Matlab',
	'Swift',
	'Kotlin',
    'R',
	'Go',
	'Rust',
	'TypeScript',
	'HTML',
	'CSS',
	'SQL',
];

sort($talen);
for ($i = 0; $i < count($talen); $i++) {
    echo $talen[$i], ", ";
}

?>
