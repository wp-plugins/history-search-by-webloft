<?php

// Inneholder basenavn og funksjoner for å konvertere slug<=>navn
// slug |x| navn |x| URL til mer info

$basenavn = array();

$basenavn[] = "bokhylla|x|Bokhylla|x|http://www.nb.no/Tilbud/Samlingen/Samlingen/Boeker/Bokhylla.no";
$basenavn[] = "nbbilder|x|Bilder fra NB|x|http://www.nb.no/Tilbud/Samlingen/Samlingen/Bilder";
$basenavn[] = "lokalhistoriewiki|x|Lokalhistoriewiki|x|https://lokalhistoriewiki.no/index.php/Hjelp:Om_wikien";
$basenavn[] = "norvegianaalle|x|Norvegiana (alle)|x|http://no.wikipedia.org/wiki/Norvegiana_API";
$basenavn[] = "norvegianadifo|x|Norvegiana (Digitalt fortalt)|x|http://digitaltfortalt.no/info/about";
$basenavn[] = "norvegianadimu|x|Norvegiana (Digitalt Museum)|x|https://digitaltmuseum.no/info/digitaltmuseum";
$basenavn[] = "baerumkunst|x|Bærum biblioteks kunstbase|x|http://bibliotek.baerum.kommune.no/Nyheter/Kunstsamling";
$basenavn[] = "baerumbilder|x|Bærum biblioteks bildebase|x|http://bibliotek.baerum.kommune.no/lokalhistorie/Bilder-fra-Barum/Lokalhistoriske-bilder";
$basenavn[] = "askerbilder|x|Asker biblioteks bildebase|x|http://www.askerbibliotek.no/askersamling/bilder";

function basetilslug ($base, $basenavn) {
	foreach ($basenavn as $enbase) {
		$splitt = explode ("|x|" , $enbase);
		if ($base == $splitt[1]) {
			return ($splitt[0]);
		}
	}
	return FALSE;
}

function slugtilbase ($slug, $basenavn) {
	foreach ($basenavn as $enbase) {
		$splitt = explode ("|x|" , $enbase);
		if ($slug == $splitt[0]) {
			return ($splitt[1]);
		}
	}
	return FALSE;
}
