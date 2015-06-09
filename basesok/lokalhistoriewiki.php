<?php

// Søker i lokalhistoriewiki og legger til treff i $treffliste

$rawurl = "http://lokalhistoriewiki.no/api.php?action=opensearch&search=<!QUERY!>&limit=" . $makstreff;

$rawurl = str_replace ("<!QUERY!>" , $search_string , $rawurl); // sette inn søketerm
$antalltreff['lokalhistoriewiki'] = ''; // nullstiller i tilfelle søket feiler
$lokalhistoriewikitreff = '';


// TREFFLISTE KOMMER SOM JSON

$jsonfile = get_content($rawurl);
$jsondata = json_decode($jsonfile);

$treffliste = $jsondata[1]; // her ligger treffene

// FINNE ANTALL TREFF
$antalltreff['lokalhistoriewiki'] = count ($treffliste);

// ... SÅ HVERT ENKELT TREFF
	$teller = 0;
	if ($antalltreff['lokalhistoriewiki'] > 0) { // dette gjør vi bare hvis vi har treff
		foreach ($treffliste as $enkelttreff) {
			$treffurl = str_replace (" " , "_" , $enkelttreff);			
			$lokalhistoriewikitreff[$teller]['url'] = "http://lokalhistoriewiki.no/index.php/" . $treffurl;
			$lokalhistoriewikitreff[$teller]['tittel'] = $enkelttreff;
			$lokalhistoriewikitreff[$teller]['bilde'] = $lokalhistoriewikiomslag;
			$lokalhistoriewikitreff[$teller]['kilde'] = "lokalhistoriewiki.no";
			$lokalhistoriewikitreff[$teller]['slug'] = "lokalhistoriewiki";
			$lokalhistoriewikitreff[$teller]['beskrivelse'] = "En artikkel fra lokalhistoriewiki.no";
			$teller++;
		} // SLUTT PÅ HVERT ENKELT TREFF
	}

$treff = @array_merge_recursive ((array) $lokalhistoriewikitreff , (array) $treff);

?>
