<?php

// Søker i Bærum biblioteks bildebase og legger til treff i $treffliste
// Kilder: Standard for fotokatalogisering, ABM-skrift #44
// http://www.kulturradet.no/documents/10157/d8681d12-c2f9-446d-88d3-5858f4fc9cfc


$domain = "http://www.barum.folkebibl.no";
$rawurl = "http://www.barum.folkebibl.no/cgi-bin/sru-lokalsamling?version=1.2&operation=searchRetrieve&maximumRecords=" . $makstreff . "&query=<!QUERY!>";

$rawurl = str_replace ("<!QUERY!>" , $search_string , $rawurl); // sette inn søketerm
$antalltreff['baerumbilder'] = ''; // nullstiller i tilfelle søket feiler
$baerumbildertreff = '';
$srw = '';

$sru_datafil = get_content($rawurl);

if(substr($sru_datafil, 0, 5) == "<?xml") { // vi fikk en XML-fil tilbake
	$sru_data    = simplexml_load_string($sru_datafil);

	$namespaces = $sru_data->getNameSpaces(true);
	$srw        = $sru_data->children($namespaces['SRU']); // alle som er srw:ditten og srw:datten
	$antalltreff['baerumbilder'] = $srw->numberOfRecords;
}

// Så ta selve filen og plukke ut det vi skal ha

$hepphepp = str_replace("marcxchange:", "", $sru_datafil);
$hepphepp = strip_tags($hepphepp, "<record><leader><controlfield><datafield><subfield>");
$hepphepp = stristr($hepphepp, "<record");

$newfile = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n";
$newfile .= "<collection>\n";
$newfile .= $hepphepp;
$newfile .= "</collection>";

// Retrieve a set of MARC records from a file

require_once 'File/MARCXML.php';

$journals = new File_MARCXML($newfile, File_MARC::SOURCE_STRING);

// Iterate through the retrieved records

$hitcounter = 0;

/*
ID
slug
url
bilde
tittel
ansvar
beskrivelse
*/

while ($record = $journals->next()) {

$beskrivelse = '';

	// ID
	if ($record->getField("001")) {
		$baerumbildertreff[$hitcounter]['id'] = ($record->getField("001"));
		$baerumbildertreff[$hitcounter]['id'] = substr($baerumbildertreff[$hitcounter]['id'] , 5);
	}

	// Slug
	$baerumbildertreff[$hitcounter]['slug'] = 'baerumbilder';

	// URL og bilde er det samme
	if ($record->getField("856")) {
		if ($record->getField("856")->getSubfield("u")) {
			$baerumbildertreff[$hitcounter]['bilde'] = $record->getField("856")->getSubfield("u");
			$baerumbildertreff[$hitcounter]['bilde'] = $domain . substr($baerumbildertreff[$hitcounter]['bilde'], 5); // fjerne feltkoden i starten
		}
	}

	@$baerumbildertreff[$hitcounter]['url'] = $domain . "/cgi-bin/websok-lokalsamling?tnr=" . trim($baerumbildertreff[$hitcounter]['id']);

	// Tittel, ev. med årstall i 260
	if ($record->getField("245")) {
		if ($record->getField("245")->getSubfield("a")) {
			$baerumbildertreff[$hitcounter]['tittel'] = $record->getField("245")->getSubfield("a");
			$baerumbildertreff[$hitcounter]['tittel'] = substr($baerumbildertreff[$hitcounter]['tittel'], 5); // fjerne feltkoden i starten
		}
	}
	if ($record->getField("260")) {
		if ($record->getField("260")->getSubfield("c")) {
			$baerumbildertreff[$hitcounter]['tittel'] .= " (" . substr($record->getField("260")->getSubfield("c") , 5) . ")";
		}
	}

	// Ansvar
	if ($record->getField("100")) {
		if ($record->getField("100")->getSubfield("a")) {
			$baerumbildertreff[$hitcounter]['ansvar'] = $record->getField("100")->getSubfield("a");
			$baerumbildertreff[$hitcounter]['ansvar'] = substr($baerumbildertreff[$hitcounter]['ansvar'], 5); // fjerne feltkoden i starten
		}
		if ($record->getField("100")->getSubfield("d")) {
			$baerumbildertreff[$hitcounter]['ansvar'] .= " (" . substr($record->getField("100")->getSubfield("d") , 5) . ")";
		}
	}

	// Beskrivelse
	if ($record->getField("300")) {
		if ($record->getField("300")->getSubfield("a")) {
			$beskrivelse[] = substr($record->getField("300")->getSubfield("a") , 5);
		}
		if ($record->getField("300")->getSubfield("b")) {
			$beskrivelse[] = str_replace ("- " , "" , substr($record->getField("300")->getSubfield("b") , 5));
		}
		if ($record->getField("300")->getSubfield("c")) {
			$beskrivelse[] = substr($record->getField("300")->getSubfield("c") , 5);
		}
		$baerumbildertreff[$hitcounter]['beskrivelse'] = "<strong>Format: </strong>" . implode (" / " , $beskrivelse);
	}
	
	// Mer beskrivelse: Generell note (500)
	if ($record->getField("500")) {
		if ($record->getField("500")->getSubfield("a")) {
			$baerumbildertreff[$hitcounter]['beskrivelse'] .= "<br>" . substr ($record->getField("500")->getSubfield("a") , 5);
		}
	}

	// Mer beskrivelse: Generell note (505)
	if ($record->getField("505")) {
		if ($record->getField("505")->getSubfield("a")) {
			@$baerumbildertreff[$hitcounter]['beskrivelse'] .= "<br><strong>Motiv: </strong>" . substr ($record->getField("505")->getSubfield("a") , 5);
		}
	}

	// Mer beskrivelse: Plassering (590)
	if ($record->getField("590")) {
		if ($record->getField("590")->getSubfield("a")) {
			$baerumbildertreff[$hitcounter]['beskrivelse'] .= "<br><strong>Plassering: </strong>" . substr ($record->getField("590")->getSubfield("a") , 5);
		}
		if ($record->getField("590")->getSubfield("b")) {
			$baerumbildertreff[$hitcounter]['beskrivelse'] .= " - " . substr ($record->getField("590")->getSubfield("b") , 5);
		}
	}

	// REPETERBARE FELTER

	foreach ($record->getFields() as $tag => $subfields) {

		// Personer - repeterbart (600)

		if ($tag == '600') {
			foreach ($subfields->getSubfields() as $code => $value) {
				$ettfelt[(string) $code] = substr((string) $value, 5);
			}
			$person[] = $ettfelt['a'];
		}

		// Emneord - Repeterbart!! (650)

		if ($tag == '650') {
			foreach ($subfields->getSubfields() as $code => $value) {
				$ettfelt[(string) $code] = substr((string) $value, 5);
			}
			$emne[] = $ettfelt['a'];
		}

	}

	if (is_array($emne)) {	
		$baerumbildertreff[$hitcounter]['beskrivelse'] .= "<br><b>Emneord: </b>" . implode (" ; " , $emne);
	}

	if (@is_array($person)) {
		$baerumbildertreff[$hitcounter]['beskrivelse'] .= "<br><b>Personer: </b>" . implode (" ; " , $person);
	}

	$emne = '';
	$person = '';


	$hitcounter++;	
} // SLUTT PÅ HVERT ENKELT TREFF

$treff = array_merge_recursive ((array) $baerumbildertreff , (array) $treff);
	
?>

