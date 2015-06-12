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

foreach ($treff as $enkelttreff) {
	$thisslug = $enkelttreff['slug'];
	@$outhtml = str_replace ("classString" , $enkelttreff['slug'] , $singlehtml);
	@$outhtml = str_replace ("urlString" , $enkelttreff['url'] , $outhtml);
	@$outhtml = str_replace ("omslagString" , $enkelttreff['bilde'] , $outhtml);
	@$outhtml = str_replace ("titleString" , $enkelttreff['tittel'] , $outhtml);
	if ((isset($enkelttreff['ansvar'])) && ($enkelttreff['ansvar'] != '')) {
		$outhtml = str_replace ("ansvarString" , "<h4>" . $enkelttreff['ansvar'] . "</h4>", $outhtml);
	} else {
		$outhtml = str_replace ("ansvarString" , '' , $outhtml);
	}
	$outhtml = str_replace ("descriptionString" , trunc($enkelttreff['beskrivelse'] , 100) , $outhtml);
	$outhtml = str_replace ("urltwitString" , urlencode($enkelttreff['url']) , $outhtml);

	$twitter = $enkelttreff['tittel'];
	if ((isset($enkelttreff['ansvar'])) && ($enkelttreff['ansvar'] != '')) {
		$twitter .= " - " . $enkelttreff['ansvar'];
	}
	$twitter = preg_replace('/[ \t]+/', ' ', preg_replace('/[\r\n]+/', "\n", $twitter)); //
	$twitter = str_replace ("<br>" , " " , $twitter);
	$twitter = strip_tags ($twitter);

	$outhtml = str_replace ("twitterString" , htmlspecialchars($twitter) , $outhtml);
	
	// Ferdig med å lage HTML for ett treff - legger dette til riktig treffliste
	@$treffhtml[$thisslug] .= $outhtml;

}

?>

<div class="resultatliste">

<?php
foreach ($lokalhistbaser as $enbase) { 
	$temp = explode("|x|" , $enbase);
	$slug = $temp[0];
	$navn = $temp[1];
	?>

	<div class="resultatheader">
		<?php echo $navn;?> (<?php echo (int) $antalltreff[$slug]; ?> treff)
	</div>
	<div class="trekkspillseksjon">
		<?php
		if (!empty($treffhtml[$slug])) {
			echo "<table>\n";
			echo $treffhtml[$slug];
			echo "</table>\n";
		} 
		?>
		<br style="clear: both;">
	</div>

<?php
}
?>

</div>


</body>
</html>
