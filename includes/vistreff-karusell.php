<?php

// Viser treffliste
$treffliste = '';
$treffhtml = '';

// HVERT TREFF: slug, url, bilde, tittel, ansvar, beskrivelse

// MAL FOR HVERT TREFF: classString , urlString , omslagString, titleString, descriptionString, urltwitString, twitterdescriptionString, gotournString

$singlehtml = '<div class="oneitem">';
$singlehtml .= '<a href="urlString" target="_blank">' . "\n";
$singlehtml .= '<img style="width: 100%;" src="omslagString" alt="tittelString" />' . "\n";
$singlehtml .= '<div class="karusellcaption">bildetekstString</div>' . "\n";
$singlehtml .= '</a>' . "\n";
$singlehtml .= '</div>' . "\n\n";


foreach ($treff as $enkelttreff) {
	$thisslug = $enkelttreff['slug'];
	@$outhtml = str_replace ("urlString" , $enkelttreff['url'] , $singlehtml);
	@$outhtml = str_replace ("tittelString" , htmlentities($enkelttreff['tittel']) , $outhtml);
	@$outhtml = str_replace ("omslagString" , $enkelttreff['bilde'] , $outhtml);

	$bildetekst = "<h2 style=\"margin: 0; line-height: 1em;\">" . str_replace ("<br>" , " - " ,$enkelttreff['tittel']) . "</h2>\n";
	if (isset($enkelttreff['ansvar'])) {
		$bildetekst .= str_replace ("<br>" , ". " , $enkelttreff['ansvar']) . "\n";
	}
	$bildetekst .= "<br>" . trunc($enkelttreff['beskrivelse'] , 100) . "\n";

	@$outhtml = str_replace ("bildetekstString" , $bildetekst , $outhtml);

	// Ferdig med å lage HTML for ett treff - legger dette til riktig treffliste
	@$treffhtml .= $outhtml;

}

?>

<div id="gridcontainer">

<div class="kulturslick">

<?= $treffhtml ?>

</div>
</div>

</body>
</html>
