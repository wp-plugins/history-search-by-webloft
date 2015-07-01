<?php

// skal motta lenke, bilde, tittel
// dynamisk lage og-data
// så videresende til lenke
// params: 0: Tittel 1: Beskrivelse (IKKE FOR LANG!) 2: url 3: bilde 4: ansvar

$param = strip_tags(stripslashes(base64_decode($param)));
$params = explode ("|x|", $param);

$tittel = $params[0];
$beskrivelse = $params[1];
$url = $params[2];
$bilde = $params[3];
$ansvar = $params[4];

list($width, $height, $type, $attr) = getimagesize($bilde);

header('Content-type: text/html; charset=utf-8');

?>
<html>
    <head>
        <meta charset="utf-8">

        <title>Du blir straks sendt videre</title>

        <meta name="twitter:card" content="photo" />
        <meta name="twitter:site" content="@bibvenn" />
        <meta name="twitter:title" content="<?= $tittel ?> (<?= $ansvar ?>)" />
        <meta name="twitter:image" content="<?= $bilde ?>" />
        <meta name="twitter:url" content="<?= $url ?>" />

        <meta name="author" content="<?= $ansvar ?>" />
        <meta property="og:type" content="book" />
        <meta property="book:author" content="<?= $ansvar ?>">
        <meta property="og:description" content="<?= $beskrivelse ?>">
        <meta property="og:title" content="<?= $tittel ?>">
        <meta property="og:image" content="<?= $bilde ?>">
        <meta property="og:image:type" content="image/jpeg">
        <meta property="og:image:height" content="<?= $height ?>">
        <meta property="og:image:width" content="<?= $width;?>">

        <meta http-equiv="refresh" content="1;<?= $url ?>">
    </head>
    <body>
...
    </body>
</html>
