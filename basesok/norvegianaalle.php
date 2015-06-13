<?php

// Søker i norvegiana og legger til treff i $treffliste

$rawurl = "http://kulturnett2.delving.org/api/search?rows=" . $makstreff . "&query=dc_title_text:<!QUERY!>%20AND%20delving_hasDigitalObject%3Atrue";


// LEGGE TIL ?start=N for result page N
// LEGGE TIL ?rows=N for antall treff per side

$rawurl = str_replace ("<!QUERY!>" , $search_string , $rawurl); // sette inn søketerm
$antalltreff['norvegianaalle'] = ''; // nullstiller i tilfelle søket feiler
$norvegianaalletreff = '';


// LASTE TREFFLISTE SOM XML

$xmlfile = get_content($rawurl);

if(substr($xmlfile, 0, 5) == "<?xml") { // vi fikk en XML-fil tilbake

	$xmldata = simplexml_load_string($xmlfile);

	// FINNE ANTALL TREFF
	$antalltreff['norvegianaalle'] = $xmldata->query->attributes()->numFound;

	// ... SÅ HVERT ENKELT TREFF
	$teller = 0;
	foreach ($xmldata->items->item as $entry) {
		$ferdigdato = '';
		$stedsinfo = '';

		if ($teller < $makstreff) {

			$delving = $entry->fields->children('delving', true);
			$dc = $entry->fields->children('dc', true);
			$abm = $entry->fields->children('abm', true);

			// DATO
			if (isset($dc->date)) {
				if ((stristr($dc->date, "start=")) || (stristr($dc->date, "end="))) { // dilledato
					$rawdates = explode (";" , $dc->date);
					foreach ($rawdates as $onedate) {
						$leddene = explode ("=" , $onedate);
							if ($leddene[0] == "start") {
								$startdato = substr ($leddene[1], 0, 4);
							}

							if ($leddene[0] == "end") {
								$sluttdato = substr ($leddene[1], 0, 4);
							}
					}
	
					if ((isset($startdato)) && ($startdato != '')) {
						$mindato = $startdato;
						if ((isset($sluttdato)) && ($sluttdato != '') && ($startdato != $sluttdato)) {
							$mindato .= "-" . $sluttdato;
						}
					} else if ((isset($sluttdato)) && ($sluttdato != '')) {
						$mindato = $sluttdato;
					}				

/*
					$rawdate = substr ($dc->date, 6, 10);
					$mindato = substr ($rawdate, 8, 2) . "." . substr ($rawdate, 5, 2) . "." . substr ($rawdate , 0, 4);
					if (substr($mindato, 0, 6) == "01.01.") { // Første i første er som regel bare tull
						$mindato = substr($mindato, 6, 4);
					}
*/
				} else { // ikke tulledato
				$mindato = $dc->date;
				}
			}

			if ($abm->estateNr != "") {
				$stedsinfo[] = $abm->estateName . " " . $abm->estateNr;
			}
			if ($abm->namedPlace != "") {
				$stedsinfo[] = $abm->namedPlace;
			}
			if ($abm->municipality != "") {
				$stedsinfo[] = $abm->municipality;
			}
			if ($abm->county != "") {
				$stedsinfo[] = $abm->county;
			}
			$stedet = @implode (", " , $stedsinfo);
			if (trim($stedet) != "") {
				$stedet = "<br><strong>Sted: </strong>" . $stedet;
			}

			$norvegianaalletreff[$teller]['url'] = $delving->landingPage;
			$norvegianaalletreff[$teller]['beskrivelse'] = htmlspecialchars(strip_tags($delving->description));

			// Hvis vi finner ting som &amp;oslash er det en html-encoding for mye...
			
			if ((stristr($norvegianaalletreff[$teller]['beskrivelse'] , "&amp;oslash")) || (stristr($norvegianaalletreff[$teller]['beskrivelse'] , "&amp;aring"))) { // rart med tegnene her...
				$norvegianaalletreff[$teller]['beskrivelse'] = html_entity_decode($norvegianaalletreff[$teller]['beskrivelse']);
			}

			$norvegianaalletreff[$teller]['beskrivelse'] .= $stedet;
			if ((isset($mindato)) && ($mindato != "")) {
				$norvegianaalletreff[$teller]['beskrivelse'] .= "<br /><strong>Datering: </strong>" . $mindato;
			}
			if (isset($delving->creator)) {
				$norvegianaalletreff[$teller]['tittel'] = htmlspecialchars($delving->creator);
			} else {
				$norvegianaalletreff[$teller]['tittel'] = htmlspecialchars($delving->title);
			}	
			$norvegianaalletreff[$teller]['bilde'] = $delving->thumbnail;
			$norvegianaalletreff[$teller]['kilde'] = "Norvegiana (alle)";
			$norvegianaalletreff[$teller]['slug'] = 'norvegianaalle';
	
			$teller++;
			
		}
	} // SLUTT PÅ HVERT ENKELT TREFF
} // Slutt på "vi fikk XML tilbake"

$treff = array_merge_recursive ((array) $norvegianaalletreff , (array) $treff);

?>

