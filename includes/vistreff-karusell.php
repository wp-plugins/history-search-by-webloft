<?php

// Viser treffliste
$treffliste = '';
$treffhtml = '';

echo "<!--\n";
echo "/***********************************************\n";
echo "* Accordion Content script- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)\n";
echo "* Visit http://www.dynamicDrive.com for hundreds of DHTML scripts\n";
echo "* This notice must stay intact for legal use\n";
echo "***********************************************/\n";
echo "-->\n";

// HVERT TREFF: slug, url, bilde, tittel, ansvar, beskrivelse

// MAL FOR HVERT TREFF: classString , urlString , omslagString, titleString, descriptionString, urltwitString, twitterdescriptionString, gotournString

$singlehtml = '<div class="oneitem">';
$singlehtml .= '<a href="urlString" target="_blank">' . "\n";
$singlehtml .= '<img style="width: 100%;" src="omslagString" alt="descriptionString" />' . "\n";
$singlehtml .= '<div class="karusellcaption">bildetekstString</div>' . "\n";
$singlehtml .= '</a>' . "\n";
$singlehtml .= '</div>' . "\n\n";


/*
$singlehtml = '';
$singlehtml .= "<tr class=\"lokalhistrow classString\">\n";

$singlehtml .= "<td class=\"lokalhisttd\" style=\"width: 40%;\">\n";
$singlehtml .= "<a href=\"urlString\" target=\"_blank\">";
$singlehtml .= "<img class=\"lokalhistorieresultcover\" src=\"omslagString\" alt=\"illustrasjonsbilde\" />\n";
$singlehtml .= "</a><br>" . "\n";
$singlehtml .= '<a target="_blank" href="https://twitter.com/intent/tweet?url=urltwitString&via=bibvenn&text=twitterString&related=bibvenn,sundaune&lang=no"><img style="width: 20px; height: 20px;" src="' . $litentwitt . '" alt="Twitter-deling" /></a>&nbsp;' . "\n";
$singlehtml .= "<a target=\"_self\" href=\"javascript:fbShare('gotournString', 700, 350)\"><img style=\"width: 50px; height: 21px;\" src=\"" . $litenface . "\" alt=\"Facebook-deling\" /></a>" . "\n";
$singlehtml .= "</td>" . "\n";

$singlehtml .= "<td class=\"lokalhisttd\">\n";
$singlehtml .= "<a href=\"urlString\" target=\"_blank\">" . "\n";
$singlehtml .= "<h3>titleString</h3>\n";
$singlehtml .= "</a>\n";
$singlehtml .= "ansvarString" . "\n";
$singlehtml .= "<div class=\"lokalhistorieresultdescription\">descriptionString</div><br />\n";
$singlehtml .= "</td>\n";
$singlehtml .= "</tr>\n\n";
*/


foreach ($treff as $enkelttreff) {
	$thisslug = $enkelttreff['slug'];
	@$outhtml = str_replace ("urlString" , $enkelttreff['url'] , $singlehtml);
	@$outhtml = str_replace ("omslagString" , $enkelttreff['bilde'] , $outhtml);

	$bildetekst = "<h2 style=\"margin: 0; line-height: 1em;\">" . str_replace ("<br>" , " - " ,$enkelttreff['tittel']) . "</h2>\n";
	$bildetekst .= str_replace ("<br>" , ". " , $enkelttreff['ansvar']) . "\n";
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
