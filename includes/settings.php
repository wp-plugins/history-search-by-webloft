<?php

// Standardverdier

$baser = ""; 
$makstreff = "";
$visning = "";

?>
<div class="wrap">

    <h1>WL Kultursøk - lag din egen shortcode</h1>

	<p>På denne siden kan du gjøre alle valgene for hvordan søket skal se ut på siden din. Nå du lagrer disse valgene ved å klikke på knappen nederst på siden, blir feltet med kortkoden (shortcode) oppdatert. Denne kan du så kopiere og lime inn i et innlegg eller på en side.
	</p>

    <form action="#" id="shortcodeform">

        <h3>Baser å ha med</h3>

        <p>
		<?php
		echo '<table border="1">' . "\n";
		require_once ("basenavn.php");
		foreach ($basenavn as $enbase) {
			$splitt = explode ("|x|" , $enbase);
			echo $splitt[1] . "&nbsp";
			echo '<input name="baser[]" type="checkbox" value="' . $splitt[0] . '" />';
			merbaseinfo ($splitt[2]);
			echo "<br>\n\n";
		}
		echo "</table>";

		
/*

    Artsdatabanken - IKKE FORELØPIG
    X - Digitalt fortalt – difo
    X - DigitaltMuseum – DiMu
    Industrimuseum
    Kulturminnesøk
    MUSIT
    Naturbase
    Stedsnavn
*/
?>

		</p>

		<h3>Utseende</h3>
		<p>

		<label for="visning">Hvordan skal vi vise trefflisten?</label>&nbsp;
		<select name="visning">
		<option value="trekkspill" selected>Trekkspill</option>
<!--	<option value="enkelliste">(Enkel liste)</option>-->
		<option value="flislagt">Flislagt</option>
<!--	<option value="slideshow">(Slideshow)</option>-->
<!--	<option value="rss">(RSS)</option>-->
		</select>
		<br>

		<label for="makstreff">Hvor mange treff skal vi maksimalt hente fra hver base?</label>&nbsp;
		<select name="makstreff">
		<option value="5">5</option>
		<option value="10">10</option>
		<option value="15" selected>15</option>
		<option value="20">20</option>
		<option value="25">25</option>
		</select>
	
	    </form>

		</p>

		<h3>Shortcode til å lime inn i innlegg eller på sider</h3>

		<div id="ferdigshortcode"></div>
		
</div>
