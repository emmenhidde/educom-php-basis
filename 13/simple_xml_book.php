<?php

$file_name = __DIR__ ."/library.xml";
$xml_doc = false;
$error_message = "";

if (is_file($file_name)) {
	$previous_libxml_setting = libxml_use_internal_errors(true);
	$xml_doc = @simplexml_load_file($file_name);

	if ($xml_doc === false) {
		$xml_errors = libxml_get_errors();
		$error_message = "Het XML-bestand kon niet worden ingelezen.";
		if (count($xml_errors) > 0) {
			$error_message .= " " . trim($xml_errors[0]->message);
		}
	}

	libxml_clear_errors();
	libxml_use_internal_errors($previous_libxml_setting);
} else {
	$error_message = "Bestand library.xml niet gevonden.";
}

function escapeHtml($value) {
	return htmlspecialchars((string) $value, ENT_QUOTES, "UTF-8");
}

function makeBold($str) {
	return "<b>" . escapeHtml($str) . "</b>";
}

?>
<!DOCTYPE html>
<html lang="nl">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Boeken uit library.xml</title>
	<style>
		.book {
			margin-bottom: 20px;
			padding: 15px;
			border: 1px solid rgb(50, 50, 180);
			background: rgb(240, 240, 255);
		}

		.book h2 {
			margin-top: 0;
		}

		th {
			text-align: left;
		}
	</style>
</head>
<body>
	<h1>Boeken uit library.xml</h1>

	<?php if ($error_message !== ""): ?>
		<p><?php echo escapeHtml($error_message); ?></p>
	<?php else: ?>
		<?php foreach ($xml_doc->book as $book): ?>
			<div class="book">
				<h2><?php echo escapeHtml($book->title); ?></h2>
				<table>
					<tbody>
						<?php foreach ($book->children() as $key => $value): ?>
							<?php if ($key !== "title"): ?>
								<tr>
									<th><?php echo makeBold($key); ?></th>
									<td>
										<?php if ($key === "authors"): ?>
											<?php
											$authors = array();

											foreach ($value->author as $author) {
												$authors[] = escapeHtml($author);
											}

											echo implode(", ", $authors);
											?>
										<?php else: ?>
											<?php echo escapeHtml($value); ?>
										<?php endif; ?>
									</td>
								</tr>
							<?php endif; ?>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		<?php endforeach; ?>
	<?php endif; ?>
</body>
</html>
