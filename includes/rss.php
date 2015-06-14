<?php
header('Content-Type: application/xhtml+xml; charset=utf-8');

$treff = unserialize(base64_decode($_POST['treffdata']));

/*
*
* Nå må vi lage feeden
*
*/

$feedtittel = "RSS-feed fra Webløft Kultursøk, totalt " . count($treff) . " treff";

$feed = "";

$feed .= "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$feed .= "<rss version=\"2.0\" xmlns:atom=\"http://www.w3.org/2005/Atom\">\n\n";

$feed .= "<channel>\n";
$feed .= "<atom:link href=\"http://" . $_SERVER['HTTP_HOST'] . urlencode($_SERVER['REQUEST_URI']) . "\" rel=\"self\" type=\"application/rss+xml\" />\n";
$feed .= "<title><![CDATA[" . strip_tags(stripslashes($feedtittel)) . "]]></title>\n";
$feed .= "<link><![CDATA[http://www.bibvenn.no]]></link>\n";
$feed .= "<description><![CDATA[WL Kultursøk - en Wordpress-utvidelse fra Webløft]]></description>\n";
$feed .= "<lastBuildDate>" . date("r") . "</lastBuildDate>\n";
$feed .= "<language>no</language>\n";
$feed .= "<copyright>Webløft / Bibliotekarens Beste Venn " . date("Y") . "</copyright>\n";
$feed .= "<image>\n";
$feed .= "<title><![CDATA[" . strip_tags(stripslashes($feedtittel)) . "]]></title>\n";
$feed .= "<url>http://www.bibliotekarensbestevenn.no/maler/g/rsslogo.png</url>\n";
$feed .= "<width>144</width>\n";
$feed .= "<height>47</height>\n";
$feed .= "<link>http://www.bibvenn.no</link>\n";
$feed .= "</image>\n\n";

foreach ($treff as $enkelttreff) { // Her kommer hvert item

	$feed .= "<item>\n";
	$feed .= "<title><![CDATA[" . $enkelttreff['tittel'] . "]]></title>\n";
	$feed .= "<description><![CDATA[<img src=\"" . $enkelttreff['bilde'] . "\" alt=\"" . $enkelttreff['tittel'];
	$feed .= "\" />" . $enkelttreff['beskrivelse'] . "]]></description>\n";
	$feed .= "<link>" . $enkelttreff['url'] . "</link>\n";
	$feed .= "<guid>" . $enkelttreff['url'] . "</guid>\n";
	$feed .= "<pubDate>" . date("r") . "</pubDate>\n";
	$feed .= "<category><![CDATA[" . $enkelttreff['kilde'] . "]]></category>\n";
	$feed .= "</item>\n";

}	// Slutt på hvert item

$feed .= "</channel>\n"; 
$feed .= "</rss>";

echo $feed;
?>
