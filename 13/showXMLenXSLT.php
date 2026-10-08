<?php
/*
XML om in te voeren:

<films>
    <film>
        <titel>The Odyssey</titel>
        <regisseur>Christopher Nolan</regisseur>
        <jaar>2026</jaar>
        <duur>150</duur>
        <imdb>8.2</imdb>
    </film>
    <film>
        <titel>Dune: Part Three</titel>
        <regisseur>Denis Villeneuve</regisseur>
        <jaar>2026</jaar>
        <duur>120</duur>
        <imdb>8.1</imdb>
    </film>
    <film>
        <titel>Avatar 3</titel>
        <regisseur>James Cameron</regisseur>
        <jaar>2026</jaar>
        <duur>130</duur>
        <imdb>7.9</imdb>
    </film>
</films>
*/
/*
XSLT om in te voeren:
<xsl:stylesheet version="1.0"
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html" encoding="UTF-8"/>
    <xsl:template match="/">
        <h2>Films met IMDb-score >= 8.0</h2>
        <ul>
            <xsl:for-each select="films/film[jaar = 2026 and imdb &gt;= 8.0]">
                <li>
                    <strong><xsl:value-of select="titel"/></strong>
                    - <xsl:value-of select="regisseur"/>,
                    <xsl:value-of select="jaar"/>,
                    <xsl:value-of select="duur"/> minuten,
                    IMDb <xsl:value-of select="imdb"/>
                </li>
            </xsl:for-each>
        </ul>
    </xsl:template>
</xsl:stylesheet>
*/

$xmlInput = '';
$xsltInput = '';
$result = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $xmlInput = $_POST['xml'] ?? '';
    $xsltInput = $_POST['xslt'] ?? '';

    if ($xmlInput !== '' && $xsltInput !== '') {
        libxml_use_internal_errors(true);
        $xmlDoc = new DOMDocument();

        if (!$xmlDoc->loadXML($xmlInput)) {
            $error = 'De XML-invoer is ongeldig.';
        } else {
            $xslDoc = new DOMDocument();

            if (!$xslDoc->loadXML($xsltInput)) {
                $error = 'De XSLT-invoer is ongeldig.';
            } else {
                $processor = new XSLTProcessor();

                if (!$processor->importStylesheet($xslDoc)) {
                    $error = 'De XSLT-stylesheet kan niet worden gebruikt.';
                } else {
                    $result = $processor->transformToXML($xmlDoc);

                    if ($result === false) {
                        $error = 'De XML kon niet met deze XSLT worden verwerkt.';
                    }
                }
            }
        }
    } else {
        $error = 'Vul zowel XML als XSLT in.';

        libxml_clear_errors();
        libxml_use_internal_errors(false);
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>XSLT processor</title>
</head>
<body>
    <h1>XSLT processor</h1>
    <form method="POST">
        <table>
            <tr>
                <td><label for="xml">XML</label></td>
                <td><label for="xslt">XSLT</label></td>
            </tr>
            <tr>
                <td><textarea id="xml" name="xml" cols="50" rows="20"><?= htmlspecialchars($xmlInput, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></textarea></td>
                <td><textarea id="xslt" name="xslt" cols="50" rows="20"><?= htmlspecialchars($xsltInput, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></textarea></td>
            </tr>
            <tr>
                <td colspan="2" align="right"><input type="submit" value="Run"></td>
            </tr>
        </table>
    </form>
    <hr>
    <?php if ($error !== null): ?>
        <p><?= htmlspecialchars($error, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></p>
    <?php elseif ($result !== null): ?>
        <?= $result ?>
    <?php endif; ?>
</body>
</html>
