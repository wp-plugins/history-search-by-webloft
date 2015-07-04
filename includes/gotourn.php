<?php

// skal motta lenke, bilde, tittel
// dynamisk lage og-data
// så videresende til lenke
// params: 0: Tittel 1: Beskrivelse (IKKE FOR LANG!) 2: url 3: bilde 4: ansvar

$param = strip_tags(stripslashes(base64_decode($_REQUEST['params'])));
$params = explode ("|x|", $param);

/*
echo $_REQUEST['params'];
echo base64_decode($_REQUEST['params']);

echo "<pre>";
print_r ($params);
echo "</pre>";
*/

/*
$tittel = htmlentities($params[0], ENT_QUOTES);
$beskrivelse = htmlentities($params[1], ENT_QUOTES);
$url = htmlentities($params[2], ENT_QUOTES);
$bilde = htmlentities($params[3], ENT_QUOTES);
$ansvar = htmlentities($params[4], ENT_QUOTES);
*/

$tittel = html_entity_decode($params[0]);
$beskrivelse = $params[1];
$url = $params[2];
$bilde = $params[3];
$ansvar = html_entity_decode($params[4]);

list($width, $height, $type, $attr) = getimagesize($bilde);

header('Content-type: text/html; charset=utf-8');

?>
<html xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:og="http://ogp.me/ns#">
    <head>
        <meta charset="utf-8">

        <title>Du blir straks sendt videre</title>

        <meta name="twitter:card" content="photo">
        <meta name="twitter:site" content="@bibvenn">
        <meta name="twitter:title" content="<?= $tittel ?> (<?= $ansvar ?>)">
        <meta name="twitter:image" content="<?= $bilde ?>">
        <meta name="twitter:url" content="<?= $url ?>">

        <meta property="og:description" content="<?= $beskrivelse ?>">
        <meta property="og:title" content="<?= $tittel ?>">
        <meta property="og:image" content="<?= $bilde ?>">
        <meta property="og:image:type" content="image/jpeg">
        <meta property="og:image:height" content="<?= $height ?>">
        <meta property="og:image:width" content="<?= $width ?>">

        <meta http-equiv="refresh" content="1;<?= $url ?>">
    </head>
    <body>
...
    </body>
</html>
