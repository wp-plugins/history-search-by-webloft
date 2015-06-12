<?php

// Viser treffliste FLISLAGT
$treffliste = '';
$treffhtml = '';

require_once ('basenavn.php');

// HVERT TREFF: slug, url, bilde, tittel, ansvar, beskrivelse, basenavn

// MAL FOR HVERT TREFF: classString , urlString , omslagString, titleString, descriptionString, urltwitString, twitterdescriptionString, gotournString, basenavnString

$singlehtml = '<div class="grid-item">' . "\n";
$singlehtml .= '<a target="_blank" href="urlString">' . "\n";
$singlehtml .= "<img src=\"omslagString\" alt=\"illustrasjonsbilde\" />\n";
$singlehtml .= "<div class=\"gridinfotekst\">\n";
$singlehtml .= "basenavnString\n";
$singlehtml .= "titleString<br>descriptionString\n";
$singlehtml .= "</div>\n";
$singlehtml .= '</a>' . "\n";
$singlehtml .= '</div>' . "\n";

foreach ($treff as $enkelttreff) {
	$thisslug = $enkelttreff['slug'];

	@$outhtml = str_replace ("omslagString" , $enkelttreff['bilde'] , $singlehtml);
	@$outhtml = str_replace ("urlString" , $enkelttreff['url'] , $outhtml);
	@$outhtml = str_replace ("titleString" , $enkelttreff['tittel'] , $outhtml);
	@$outhtml = str_replace ("descriptionString" , trunc($enkelttreff['beskrivelse'], 50) , $outhtml);
	@$outhtml = str_replace ("basenavnString" , $enkelttreff['kilde'] , $outhtml);
	
	// Ferdig med å lage HTML for ett treff - legger dette til riktig treffliste
	
	if ($thisslug != 'lokalhistoriewiki') { // liten vits i å ha med - ikke bilde
		if ($enkelttreff['bilde'] != '') { // à propos... har vi egentlig bilde?
			@$treffhtml .= $outhtml;
		}
	}
}

?>

<div id="gridcontainer">
<div class="grid">

<?= $treffhtml ?>

</div>
</div>

</body>
</html>

