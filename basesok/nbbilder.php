<?php

// Søker i Nasjonalbibliotekets bilder og legger til treff i $treffliste

$rawurl = "http://www.nb.no/services/search/v2/search?q=<!QUERY!>&fq=mediatype:Bilder&fq=contentClasses:public&fq=digital:Ja&itemsPerPage=" . $makstreff . "&ft=true";

$rawurl = str_replace ("<!QUERY!>" , $search_string , $rawurl); // sette inn søketerm
$antalltreff['nbbilder'] = ''; // nullstiller i tilfelle søket feiler
$nbbildertreff = '';


// LASTE TREFFLISTE SOM XML
$xmlfile = get_content($rawurl);

if(substr($xmlfile, 0, 5) == "<?xml") { // vi fikk en XML-fil tilbake
	$xmldata = simplexml_load_string($xmlfile);

	// FINNE ANTALL TREFF
	$antalltreff['nbbilder'] = substr(stristr($xmldata->subtitle, " of ") , 4);

	// ... SÅ HVERT ENKELT TREFF
	$teller = 0;
	foreach ($xmldata->entry as $entry) {
		if ($teller < $makstreff) {

			// METADATA SOM XML FOR DETTE TREFFET
			$childxml = ($entry->link[0]->attributes()->href); // Dette er XML med metadata
			$xmlfile = get_content($childxml);
			$childxmldata = simplexml_load_string($xmlfile);
			$namespaces = $entry->getNameSpaces(true);
			$nb = $entry->children($namespaces['nb']);

			// FINNE URN			
			if (stristr($nb->urn , ";")) {
				$tempura = explode (";" , $nb->urn);
				$urn = trim($tempura[1]); // vi tar nummer 2 
			} else {
				$urn = $nb->urn[0];
			}
			
			$nbbildertreff[$teller]['bilde'] = "http://www.nb.no/gallerinor/hent_bilde.php?id=" . $childxmldata->recordInfo->recordIdentifier . "&size=1";
	
			if (stristr($nb->contentclasses , "jp2")) {
				$nbbildertreff[$teller]['bilde'] = "http://www.nb.no/services/image/resolver?url_ver=geneza&urn=" . $urn . "&maxLevel=6&level=2&col=0&row=0&resX=6000&resY=6000&tileWidth=2048&tileHeight=2048";
			}
			
			$nbbildertreff[$teller]['url'] = "http://urn.nb.no/" . $urn;
			if ((isset($nb->mainentry)) && ($nb->mainentry != '')) {
				$nbbildertreff[$teller]['tittel'] = $nb->mainentry;
			} else {
				$nbbildertreff[$teller]['tittel'] = '(Uten tittel)';
			}

			if ((isset($nb->year)) && (trim($nb->year) != '')) {
				$nbbildertreff[$teller]['utgitt'] = $nb->year;
			}
			$nbbildertreff[$teller]['beskrivelse'] = str_ireplace ("prot: ", "<strong>Protokoll: </strong>" , $entry->summary); // Fjerne "Prot: " i starten

			if (isset($nb->subjectname)) {
				$nbbildertreff[$teller]['beskrivelse'] .= "<br><strong>Motiv: </strong>" . $nb->subjectname;
			}

			if (isset($nb->subjecttopic)) {
				$nbbildertreff[$teller]['beskrivelse'] .= "<br><strong>Emneord: </strong>" . $nb->subjecttopic;
			}

			if (isset($nb->places)) {
				$nbbildertreff[$teller]['beskrivelse'] .= "<br><strong>Steder: </strong>" . $nb->places;
			}

			$nbbildertreff[$teller]['kilde'] = "Nasjonalbiblioteket - bilder";
			$nbbildertreff[$teller]['slug'] = "nbbilder";
			
			$teller++;
		}
	} // SLUTT PÅ HVERT ENKELT TREFF
} // Slutt på "vi fikk XML tilbake"

$treff = array_merge_recursive ((array) $nbbildertreff , (array) $treff);

?>
