<?php

// Viser treffliste SOM ENKEL LISTE
$treffliste = '';
$treffhtml = '';

require_once ('basenavn.php');
	
// HVERT TREFF: slug, url, bilde, tittel, ansvar, beskrivelse, basenavn

// MAL FOR HVERT TREFF: classString , urlString , omslagString, titleString, descriptionString, urltwitString, twitterdescriptionString, gotournString, basenavnString

$pendel = 0;
$row = array('rowodd' , 'roweven');

$singlehtml = '<div class="pendelString">' . "\n";
$singlehtml .= '<a target="_blank" href="urlString">' . "\n";
$singlehtml .= "<strong>titleString</strong>&nbsp;:&nbsp; ";
$singlehtml .= "descriptionString. ";
$singlehtml .= "<i>Kilde: </i>basenavnString\n";
$singlehtml .= '</a>' . "\n";
$singlehtml .= '</div>' . "\n";

foreach ($treff as $enkelttreff) {
	$pendel = (1 - $pendel);
	$thisslug = $enkelttreff['slug'];

	@$outhtml = str_replace ("urlString" , $enkelttreff['url'] , $singlehtml);
	@$outhtml = str_replace ("titleString" , $enkelttreff['tittel'] , $outhtml);
	@$outhtml = str_replace ("pendelString" , $row[$pendel] , $outhtml);

	@$outhtml = str_replace ("descriptionString" , trunc(str_replace("<br>" , ".&nbsp;" , $enkelttreff['beskrivelse']), 30) , $outhtml);
	@$outhtml = str_replace ("basenavnString" , $enkelttreff['kilde'] , $outhtml);
	
	// Ferdig med å lage HTML for ett treff - legger dette til riktig treffliste
	
	@$treffhtml .= $outhtml;

}

?>

<div id="gridcontainer">

<?= $treffhtml ?>

</div>

</body>
</html>

