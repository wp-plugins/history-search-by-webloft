<?php

// Søker i bokhylla emne lokalhistorie og legger til treff i $treffliste

$rawurl = "http://www.nb.no/services/search/v2/search?q=<!QUERY!>&fq=mediatype:(" . utf8_decode("Bøker") . ")&fq=contentClasses:(bokhylla%20OR%20public)&fq=subject:lokalhistorie&fq=digital:Ja&itemsPerPage=" . $makstreff . "&ft=" . $bokhyllaft;

$rawurl = str_replace ("<!QUERY!>" , $search_string , $rawurl); // sette inn søketerm
$antalltreff['bokhylla'] = ''; // nullstiller i tilfelle søket feiler
$bokhyllatreff = '';

// LASTE TREFFLISTE SOM XML
$xml = get_content($rawurl);

if(substr($xml, 0, 5) == "<?xml") { // vi fikk en XML-fil tilbake

	$xmldata = simplexml_load_string($xml);
	
	// FINNE ANTALL TREFF
	$antalltreff['bokhylla'] = substr(stristr($xmldata->subtitle, " of ") , 4);
	
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

			$bokhyllatreff[$teller]['tittel'] = $childxmldata->titleInfo->title;
			if (isset($childxmldata->titleInfo->subTitle)) {
				$bokhyllatreff[$teller]['tittel'] .= " : " . $childxmldata->titleInfo->subTitle;
			}
			if (isset($childxmldata->titleInfo->partNumber)) {
				$bokhyllatreff[$teller]['tittel'] .= "<br>" . $childxmldata->titleInfo->partNumber;
			}
			if (isset($childxmldata->titleInfo->partName)) {
				$bokhyllatreff[$teller]['tittel'] .= " : " . $childxmldata->titleInfo->partName;
			}

			$bokhyllatreff[$teller]['ansvar'] = $nb->namecreator;

			// UTGITT

			unset ($utgitt);
			if (isset($childxmldata->originInfo->place[1])) {
				$utgitt[] = $childxmldata->originInfo->place[1];
			}

			if (isset($childxmldata->originInfo->publisher)) {
				$utgitt[] = $childxmldata->originInfo->publisher;
			}

			if (isset($childxmldata->originInfo->dateIssued[0])) {
				$utgitt[] = $childxmldata->originInfo->dateIssued[0];
			}
			$bokhyllatreff[$teller]['utgitt'] = implode (" " , $utgitt);

			if (isset($childxmldata->physicalDescription->extent)) {
				$bokhyllatreff[$teller]['omfang'] = $childxmldata->physicalDescription->extent;
			}

			// BESKRIVELSE
			$bokhyllatreff[$teller]['beskrivelse'] = $bokhyllatreff[$teller]['utgitt'];
			$bokhyllatreff[$teller]['beskrivelse'] .= "<br>" . $bokhyllatreff[$teller]['omfang'];
			

			if (isset($childxmldata->note)) {
				$bokhyllatreff[$teller]['beskrivelse'] .= "<br>" . $childxmldata->note;
			}

			// BOKOMSLAG, SE http://www-sul.stanford.edu/iiif/image-api/1.1/#parameters
			if (stristr($nb->urn , ";")) {
				$tempura = explode (";" , $nb->urn);
				$urn = trim($tempura[1]); // vi tar nummer 2 
			} else {
				$urn = $nb->urn[0];
			}
			if ($urn != "") {
				$delavurn = substr($urn , 8);
				$bokhyllatreff[$teller]['bilde'] = "http://bokforsider.webloft.no/urn/" . $delavurn . ".jpg";
			} else {
				$bokhyllatreff[$teller]['bilde'] = $generiskbokomslag; // DEFAULTOMSLAG
			}
	
			$bokhyllatreff[$teller]['url'] = "http://urn.nb.no/" . $urn;
			$bokhyllatreff[$teller]['kilde'] = "Bokhylla";
			$bokhyllatreff[$teller]['slug'] = "bokhylla";
			$teller++;
		}
	} // SLUTT PÅ HVERT ENKELT TREFF

} // slutt på "vi fikk XML-fil tilbake

$treff = array_merge_recursive ((array) $bokhyllatreff , (array) $treff);

?>

