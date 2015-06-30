<?php
header('Content-Type: application/xhtml+xml');

/*
*
* Nå må vi lage feeden
*
*/

$feedtittel = "RSS-feed fra Webløft Kultursøk, totalt " . count($treff) . " treff";

$feed = "";
$feed .= "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$feed .= "<rss version=\"2.0\" xmlns:atom=\"http://www.w3.org/2005/Atom\">\n";
$feed .= "<channel>\n";
$feed .= "<atom:link href=\"http://" . $_SERVER['HTTP_HOST'] . urlencode($_SERVER['REQUEST_URI']) . "\" rel=\"self\" type=\"application/xhtml+xml\" />\n";
$feed .= "<title><![CDATA[" . $feedtittel . "]]></title>\n";
$feed .= "<link>http://www.bibvenn.no</link>\n";
$feed .= "<description><![CDATA[WL Kultursøk - en Wordpress-utvidelse fra Webløft]]></description>\n";
$feed .= "<lastBuildDate>" . date("r") . "</lastBuildDate>\n";
$feed .= "<language>no</language>\n";
$feed .= "<image>\n";
$feed .= "<title>Webløft Kultursøk</title>\n";
$feed .= "<url>http://www.bibliotekarensbestevenn.no/maler/g/rsslogo.png</url>\n";
$feed .= "<width>257</width>\n";
$feed .= "<height>258</height>\n";
$feed .= "<link>http://www.kultursok.no</link>\n";
$feed .= "</image>\n";

foreach ($treff as $enkelttreff) { // Her kommer hvert item

	$feed .= "<item>\n";
	$feed .= "<title><![CDATA[" . str_replace ("<br>" , " : " , $enkelttreff['tittel']) . "]]></title>\n";


	$feed .= "<description><![CDATA[<img hspace=\"5\" vspace=\"5\" align=\"left\" src=\"" . str_replace ("&" , "&amp;" , $enkelttreff['bilde']) . "\" alt=\"" . str_replace ("<br>" , " : " , $enkelttreff['tittel']);
	$feed .= "\" />";

		$tempbesk = str_replace ("&" , "&amp;" , $enkelttreff['beskrivelse']);
//		$tempbesk = str_replace ("<" , "&lt;" , $enkelttreff['beskrivelse']);
//		$tempbesk = str_replace (">" , "&gt;" , $tempbesk);
		$tempbesk = str_replace ("]" , "&#93;" , $tempbesk);
		$tempbesk = str_replace ("[" , "&#91;" , $tempbesk);
		$tempbesk = str_replace ('"' , '&#34;' , $tempbesk);
		
	$feed .= $tempbesk . "]]></description>\n";

	$feed .= "<link>" . str_replace ("&" , "x" , $enkelttreff['url']) . "</link>\n";
	$feed .= "<guid>" . str_replace ("&" , "x" , $enkelttreff['url']) . "</guid>\n";

	$feed .= "<category>" . $enkelttreff['kilde'] . "</category>\n";
	$feed .= "</item>\n";

}	// Slutt på hvert item

$feed .= "</channel>\n"; 
$feed .= "</rss>";

echo $feed;
?>
