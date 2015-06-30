<?php

// Søker i norvegiana (Digitalt fortalt) og legger til treff i $treffliste

$rawurl = "http://kulturnett2.delving.org/api/search?rows=" . $makstreff . "&query=delving_description:<!QUERY!>%20delving_hasDigitalObject%3Atrue%20delving_spec%3ADiMu";

// Gjøre noe med søkeord?

// LEGGE TIL ?start=N for result page N
// LEGGE TIL ?rows=N for antall treff per side

$rawurl = str_replace ("<!QUERY!>" , $search_string , $rawurl); // sette inn søketerm
$antalltreff['norvegianadimu'] = ''; // nullstiller i tilfelle søket feiler
$norvegianadimutreff = '';

// LASTE TREFFLISTE SOM XML

$xmlfile = get_content($rawurl);

if(substr($xmlfile, 0, 5) == "<?xml") { // vi fikk en XML-fil tilbake

	$xmldata = simplexml_load_string($xmlfile);

	// FINNE ANTALL TREFF
	$antalltreff['norvegianadimu'] = $xmldata->query->attributes()->numFound;

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

			$norvegianadimutreff[$teller]['url'] = $delving->landingPage;
			$norvegianadimutreff[$teller]['beskrivelse'] = htmlspecialchars(strip_tags($delving->description));

			// Hvis vi finner ting som &amp;oslash er det en html-encoding for mye...
			
			if ((stristr($norvegianadimutreff[$teller]['beskrivelse'] , "&amp;oslash")) || (stristr($norvegianadimutreff[$teller]['beskrivelse'] , "&amp;aring"))) { // rart med tegnene her...
				$norvegianadimutreff[$teller]['beskrivelse'] = html_entity_decode($norvegianadimutreff[$teller]['beskrivelse']);
			}
			$norvegianadimutreff[$teller]['beskrivelse'] = str_replace ("&amp;nbsp;" , " " , $norvegianadimutreff[$teller]['beskrivelse']); // mer kål med tegn

			$norvegianadimutreff[$teller]['beskrivelse'] .= $stedet;
			if ((isset($mindato)) && ($mindato != "")) {
				$norvegianadimutreff[$teller]['beskrivelse'] .= "<br /><strong>Datering: </strong>" . $mindato;
			}

			if (isset($dc->title)) {
				$norvegianadimutreff[$teller]['tittel'] = htmlspecialchars($dc->title);
			}

			if (isset($dc->creator)) {
				$norvegianadimutreff[$teller]['ansvar'] = htmlspecialchars($dc->creator);
			}

			$norvegianadimutreff[$teller]['bilde'] = $delving->thumbnail;
			$norvegianadimutreff[$teller]['kilde'] = "Norvegiana (Digitalt Museum)";
			$norvegianadimutreff[$teller]['slug'] = 'norvegianadimu';

			$teller++;
			
		}
	} // SLUTT PÅ HVERT ENKELT TREFF
} // Slutt på "Vi fikk XML tilbake"

$treff = array_merge_recursive ((array) $norvegianadimutreff , (array) $treff);

// SLUTT
