<?php

//$lokalhist_debug = "1"; 

// turn on for debug

ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);


require_once("includes/functions.php"); // funksjoner vi har bruk for

// Declare variables

$treff = '';
$tittel = '';
$forfatter = '';
$bokhyllahtml = '';
$bokhyllatreff = '';
$bildertreff = '';
$nbbilderhtml = '';
$stedsinfo = '';
$lokalhistoriewikihtml = '';
$norvegianahtml = '';
$norvegianatreff = '';
$dc = '';

// Twitter- og Facebookikoner og andre bilder

$litentwitt = plugins_url ('g/twitter.png' , __FILE__);
$litenface = plugins_url ('g/fb.png' , __FILE__);
$generiskomslag = plugins_url ('g/ikke_digital.jpg' , __FILE__);
$lokalhistoriewikiomslag = plugins_url ('g/lokalhistoriewiki.jpg' , __FILE__);

// INNSTILLINGER

$makstreff = $lokalhistmakstreff; // hvor mange treff henter vi maks fra hvert sted? Definert i shortcode
if ($makstreff > 100) { // 100 er maks for noen av basene
$makstreff = 100;
}

$bokhyllaft = 'false'; // fulltekstsøk i Bokhylla? (gir myriader av treff)
$bilderft = 'true'; // fulltekstsøk i bilder? Kan like gjerne stå på

// vi trenger funksjoner
require_once ('includes/functions.php');

// Get Search
$search_string = urlencode(stripslashes(strip_tags($_REQUEST['lokalhistquery'])));
$search_string = str_replace ("\"", "%22" , $search_string);
$search_string = str_replace (" ", "%20" , $search_string);

// Define Output HTML Formatting of single item with picture

$singlehtml = '';
$singlehtml .= "<div class=\"lokalhistorieresult classString\">\n";
$singlehtml .= "<a class=\"lokalhistorieresultlink\" href=\"urlString\" target=\"_blank\">";
$singlehtml .= "<img class=\"lokalhistorieresultcover\" src=\"omslagString\" alt=\"titleString - descriptionString\" />\n";
$singlehtml .= "<b>titleString</b>\n";
$singlehtml .= "</a>\n";
$singlehtml .= "<br /><span class=\"lokalhistorieresultdescription\">descriptionString</span><br />\n";
$singlehtml .= '<a target="_blank" href="https://twitter.com/intent/tweet?url=twitterurlString&via=bibvenn&text=twitterdescriptionString&related=bibvenn,sundaune&lang=no"><img style="width: 20px; height: 20px;" src="' . $litentwitt . '" alt="Twitter-deling" /></a>&nbsp;';
$singlehtml .= "<a target=\"_self\" href=\"javascript:fbShare('urlString', 700, 350)\"><img style=\"width: 50px; height: 21px;\" src=\"" . $litenface . "\" alt=\"Facebook-deling\" /></a>";
$singlehtml .= "<br style=\"clear: both;\">";
$singlehtml .= "</div>\n\n";


$lokalhistbaser = get_option('lokalhist_option_baser' , '');

// Så søker vi i de basene som er angitt i innstillingene

foreach ($lokalhistbaser as $enbase) { 
	$temp = explode("|x|" , $enbase);
	$slug = $temp[0];
	include ('basesok/' . $slug . '.php');
}

// Gjøre om alt til rene strenger (fra XML og sånt)

function tilstreng(&$item){
   $item= (string) $item;
}

array_walk_recursive($treff,'tilstreng');


// FERDIG MED Å SØKE - SKRIVE UT RESULTATER

// array tvinger type array, ellers vil den feile hvis en av arrayene er tomme
//$treffliste = @array_merge ((array) $norvegianatreff , (array) $lokalhistoriewikitreff , (array) $bildertreff , (array) $bokhyllatreff);

// array_filter uten argumenter fjerner tomme elementer
$treff = array_filter( $treff );

include ('includes/vistreff.php');

?>


