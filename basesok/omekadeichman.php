<?php

// Søker i lokalhistoriske bildebaser til Deichman og legger til treff i $treffliste

// URL: http://bildebaser.deichman.no/items/browse?output=rss2
// http://gastonlibrary.org/omeka/items/browse

//$rawurl = "http://www.nb.no/services/search/v2/search?q=<!QUERY!>&fq=mediatype:(" . utf8_decode("Bøker") . ")&fq=contentClasses:(bokhylla%20OR%20public)&fq=subject:lokalhistorie&fq=digital:Ja&itemsPerPage=" . $makstreff . "&ft=false";

// Finne antall først

$rawurl = "http://bildebaser.deichman.no/items/browse?search=<!QUERY!>&output=omeka-xml";
$rawurl = str_replace ("<!QUERY!>" , $search_string , $rawurl); // sette inn søketerm

$xml = get_content($rawurl);

if(substr($xml, 0, 5) == "<?xml") { // vi fikk en XML-fil tilbake
	$xmldata = simplexml_load_string($xml);
	$antalltreff['omekadeichman'] = $xmldata->miscellaneousContainer->pagination->totalResults;
} else {
	$antalltreff['omekadeichman'] = 0;
}

$omekadeichmantreff = '';

// LASTE TREFFLISTE SOM XML
$xml = get_content($rawurl);

if(substr($xml, 0, 5) == "<?xml") { // vi fikk en XML-fil tilbake

	$xmldata = simplexml_load_string($xml);
	$teller = 0;
	foreach ($xmldata->item as $entry) {
		if ($teller < $makstreff) {

			$omekadeichman[$teller]['slug'] = 'omekadeichman';
			$omekadeichman[$teller]['kilde'] = 'Lokalhistoriske bildebaser i Oslo (Deichman)';
			$omekadeichman[$teller]['id'] = $entry->attributes()->itemId;
			$omekadeichman[$teller]['url'] = 'http://bildebaser.deichman.no/items/show/' . $entry->attributes()->itemId;

			$omekadeichman[$teller]['bilde'] = $entry->fileContainer->file->src;
			$omekadeichman[$teller]['bilde'] = str_replace ("/original/" , "/square_thumbnails/" , $omekadeichman[$teller]['bilde']);
			$omekadeichman[$teller]['bilde'] = str_replace (".tif" , ".jpg" , $omekadeichman[$teller]['bilde']);
			$omekadeichman[$teller]['tittel'] = $childxmldata->titleInfo->title;

domp ($entry);



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

// SLUTT
