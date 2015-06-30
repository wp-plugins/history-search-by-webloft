<?php

//$lokalhist_debug = "1"; 

// turn on for debug

ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);


// Hvis vi kommer direkte hit trenger vi WP-funksjonalitet!
if ( ! defined( 'WPINC' ) ) {
	require_once("../../../wp-load.php");
}

require_once("includes/functions.php"); // funksjoner vi har bruk for

// Declare variables

$treff = '';
$tittel = '';
$forfatter = '';
$dc = '';

$baser = esc_attr($_REQUEST['baser']);
$visning = esc_attr($_REQUEST['visning']);
$sortering = esc_attr($_REQUEST['sortering']);
$makstreff = (int) $_REQUEST['makstreff'];

// Twitter- og Facebookikoner og andre bilder

$litentwitt = plugins_url ('g/twitter.png' , __FILE__);
$litenface = plugins_url ('g/fb.png' , __FILE__);
$generiskomslag = plugins_url ('g/ikke_digital.jpg' , __FILE__);
$lokalhistoriewikiomslag = plugins_url ('g/lokalhistoriewiki.jpg' , __FILE__);

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

// Så søker vi i de basene som er angitt i innstillingene

if ($baser != '') {
	$splittbaser = explode ("," , $baser);
	foreach ($splittbaser as $enbase) { 
		include ('basesok/' . $enbase . '.php');
	}

	// Gjøre om alt til rene strenger (fra XML og sånt)
	array_walk_recursive($treff,'tilstreng');
	
	// HVILKEN SORTERING ER VALGT?

	switch ($sortering) {
		case "base":
			 // Ingen ting, dette er standard
			break;
		case "tilfeldig":
			shuffle ($treff);			
			break;
		case "tittel":
			function sortByOption($a, $b) {
				return strcmp($a['tittel'], $b['tittel']);
			}
			usort($treff, 'sortByOption');
			break;
	}

	// FERDIG MED Å SØKE - SKRIVE UT RESULTATER
	// array_filter uten argumenter fjerner tomme elementer

	$treff = array_filter( $treff );
	if (count($treff) > 0) { // må ha noen treff
		// Hvis ikke RSS så vis
		if ($visning != 'rss') { // Visning er ikke RSS
			include ('includes/vistreff-' . $visning . '.php');
		} else { // visning er RSS
			if ((isset($_REQUEST['dorss'])) && ($_REQUEST['dorss'] == '1')) { // og vi skal kjøre ut RSS
				include ('includes/rss.php'); // lag og spytt ut RSS
			} else { // Vi skal bare vise lenke til RSS
				$serverdel = plugins_url( 'search.php', __FILE__ ); // det er search.php
				$argumenter = stristr ($_SERVER['REQUEST_URI'] , "?"); // alt etter ? er argumenter, må bli med videre
				$direkterss = $serverdel . $argumenter . "&dorss=1"; // og legge til dette
				echo '<br>' . "\n";
				echo '<form method="POST" action="' . $direkterss . '">' . "\n";
				echo '<img style="border: none; box-shadow: none; width: 80px;" src="' . plugins_url( 'g/rss.png', __FILE__ ) . '" alt="Hent RSS-feed" /><br>';
				echo '<input style="width: 80px;" type="submit" name="submit" value="Hent RSS" />' . "\n";
				echo '</form>' . "\n\n";
			}
		}
	} else { // ops, vi har ingen treff
		echo "Ingen treff!";
	}
} else { // ops, ingen baser valgt
	echo "<i>Du m&aring; velge noen s&oslash;kekilder i innstillingene f&oslash;r du kan f&aring; noen treff!</i>";
}
?>
