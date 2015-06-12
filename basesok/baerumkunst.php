<?php

// Søker i Bærum biblioteks kunstbase og legger til treff i $treffliste
// Kilder: Standard for fotokatalogisering, ABM-skrift #44
// http://www.kulturradet.no/documents/10157/d8681d12-c2f9-446d-88d3-5858f4fc9cfc


$domain = "http://www.barum.folkebibl.no";
$rawurl = "http://www.barum.folkebibl.no/cgi-bin/sru-kunst?version=1.2&operation=searchRetrieve&maximumRecords=" . $makstreff . "&query=<!QUERY!>";

$rawurl = str_replace ("<!QUERY!>" , $search_string , $rawurl); // sette inn søketerm
$antalltreff['baerumkunst'] = ''; // nullstiller i tilfelle søket feiler
$baerumkunsttreff = '';
$srw = '';

$sru_datafil = get_content($rawurl);

if(substr($sru_datafil, 0, 5) == "<?xml") { // vi fikk en XML-fil tilbake

	$sru_data    = simplexml_load_string($sru_datafil);
	
	$namespaces = $sru_data->getNameSpaces(true);
	$srw        = $sru_data->children($namespaces['SRU']); // alle som er srw:ditten og srw:datten
	$antalltreff['baerumkunst'] = $srw->numberOfRecords;
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
slug
url
bilde
tittel
ansvar
beskrivelse
*/

while ($record = $journals->next()) {

$beskrivelse = '';

	// Slug
	$baerumkunsttreff[$hitcounter]['slug'] = 'baerumkunst';

	// URL og bilde er det samme
	if ($record->getField("856")) {
		if ($record->getField("856")->getSubfield("u")) {
			$baerumkunsttreff[$hitcounter]['bilde'] = $record->getField("856")->getSubfield("u");
			$baerumkunsttreff[$hitcounter]['bilde'] = $domain . substr($baerumkunsttreff[$hitcounter]['bilde'], 5); // fjerne feltkoden i starten
		}
	}
	$baerumkunsttreff[$hitcounter]['url'] = $baerumkunsttreff[$hitcounter]['bilde'];

	// Tittel, ev. med årstall i 260
	if ($record->getField("245")) {
		if ($record->getField("245")->getSubfield("a")) {
			$baerumkunsttreff[$hitcounter]['tittel'] = $record->getField("245")->getSubfield("a");
			$baerumkunsttreff[$hitcounter]['tittel'] = substr($baerumkunsttreff[$hitcounter]['tittel'], 5); // fjerne feltkoden i starten
		}
	}
	if ($record->getField("260")) {
		if ($record->getField("260")->getSubfield("c")) {
			$baerumkunsttreff[$hitcounter]['tittel'] .= " (" . substr($record->getField("260")->getSubfield("c") , 5) . ")";
		}
	}

	// Ansvar
	if ($record->getField("100")) {
		if ($record->getField("100")->getSubfield("a")) {
			$baerumkunsttreff[$hitcounter]['ansvar'] = $record->getField("100")->getSubfield("a");
			$baerumkunsttreff[$hitcounter]['ansvar'] = substr($baerumkunsttreff[$hitcounter]['ansvar'], 5); // fjerne feltkoden i starten
		}
		if ($record->getField("100")->getSubfield("d")) {
			$baerumkunsttreff[$hitcounter]['ansvar'] .= " (" . substr($record->getField("100")->getSubfield("d") , 5) . ")";
		}
	}

	// Fysisk beskrivelse
	if ($record->getField("300")) {
		if ($record->getField("300")->getSubfield("a")) {
			$baerumkunsttreff[$hitcounter]['beskrivelse'] = "<strong>Teknikk: </strong>" . substr($record->getField("300")->getSubfield("a") , 5);
		}
		if ($record->getField("300")->getSubfield("b")) {
			$baerumkunsttreff[$hitcounter]['beskrivelse'] .= substr($record->getField("300")->getSubfield("b") , 5);
		}
		if ($record->getField("300")->getSubfield("c")) {
			$baerumkunsttreff[$hitcounter]['beskrivelse'] .= "<br><strong>Dimensjoner: </strong>" . substr($record->getField("300")->getSubfield("c") , 5);
		}
	}
	
	// Mer beskrivelse: Generell note (500)
	if ($record->getField("500")) {
		if ($record->getField("500")->getSubfield("a")) {
			$baerumkunsttreff[$hitcounter]['beskrivelse'] .= "<br>" . substr ($record->getField("500")->getSubfield("a") , 5);
		}
	}


	// Mer beskrivelse: Plassering (590)
	if ($record->getField("590")) {
		if ($record->getField("590")->getSubfield("a")) {
			$baerumkunsttreff[$hitcounter]['beskrivelse'] .= "<br><strong>Plassering: </strong>" . substr ($record->getField("590")->getSubfield("a") , 5);
		}
		if ($record->getField("590")->getSubfield("b")) {
			$baerumkunsttreff[$hitcounter]['beskrivelse'] .= " - " . substr ($record->getField("590")->getSubfield("b") , 5);
		}
	}

	$hitcounter++;	
} // SLUTT PÅ HVERT ENKELT TREFF

$treff = @array_merge_recursive ((array) $baerumkunsttreff , (array) $treff);
	
?>

