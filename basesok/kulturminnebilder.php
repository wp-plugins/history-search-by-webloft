<?php

// Søker i kulturminnebilder og legger til treff i $treffliste

// Info: http://learn.fotoware.com/02_FotoWeb_8.0/Developing_with_the_FotoWeb_API/The_FotoWeb_Archive_Agent_API/04_Interface/Search_method

$rawurl = "http://kulturminnebilder.ra.no/fotoweb/fwbin/fotoweb_isapi.dll/ArchiveAgent/5001/Search?Search=<!QUERY!>&MaxHits=" . $makstreff . "&PreviewSize=300&FileInfo=1&MetaData=1";

$rawurl = str_replace ("<!QUERY!>" , $search_string , $rawurl); // sette inn søketerm
$antalltreff['kulturminnebilder'] = ''; // nullstiller i tilfelle søket feiler
$kulturminnebildertreff = '';

// LASTE TREFFLISTE SOM XML
$xml = get_content($rawurl);
rop ($rawurl);
if(substr($xml, 0, 5) == "<?xml") { // vi fikk en XML-fil tilbake
	$xmldata = simplexml_load_string($xml);

	// FINNE ANTALL TREFF
	$antalltreff['kulturminnebilder'] = $xmldata->attributes()->TotalHits;

	// ... SÅ HVERT ENKELT TREFF
	$teller = 0;
	foreach ($xmldata->File as $entry) {
//domp ($entry);
		if ($teller < $makstreff) {
	
		foreach ($entry->MetaData->Text->Field as $tekst) {
			domp ($tekst->attributes());
		}




			$teller++;
		}
	} // SLUTT PÅ HVERT ENKELT TREFF

} // slutt på "vi fikk XML-fil tilbake

$treff = array_merge_recursive ((array) $kulturminnebildertreff , (array) $treff);

// SLUTT
