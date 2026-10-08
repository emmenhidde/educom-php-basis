<?php
$postcode = trim(str_replace('  ', '', $_POST['postcode'] ?? ''));
$isValid = preg_match('/^[1-9][0-9]{3}\s?[A-Z]{2}$/i', $postcode);
?>
    
<form method="post">
	<label for="postcode">Nederlandse postcode:</label>
	<input type="text" id="postcode" name="postcode" value="<?= htmlspecialchars($postcode, ENT_QUOTES, 'UTF-8') ?>">
	<button type="submit">Controleren</button>
</form>

<?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
	<p><?= $isValid ? 'De postcode is geldig.' : 'De postcode is ongeldig.' ?></p>
<?php endif; ?>
