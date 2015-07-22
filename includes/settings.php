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
		$row[0] = 'eee';
		$row[1] = 'fff';
		$pendel = 0;
		echo '<table class="settingstabell">' . "\n";
		require_once ("basenavn.php");
		foreach ($basenavn as $enbase) {
			$splitt = explode ("|x|" , $enbase);
			echo '<tr style="background-color: #' . $row[$pendel] . ';"><td>' . $splitt[1];
			echo '</td><td><input name="baser[]" type="checkbox" value="' . $splitt[0] . '" /></td>';
			echo '<td>';
			merbaseinfo ($splitt[2]);
			echo '</td>';
			echo "</tr>\n\n";
			$pendel = (1 - $pendel);
		}
		echo "</table>";

?>

		</p>

		<h3>Utseende</h3>
		<p>
		<table class="settingstabell">
		<tr>
		<td><label for="visning">Hvordan skal vi vise trefflisten?</label></td>
		<td><select name="visning">
			<option value="trekkspill" selected>Trekkspill</option>
			<option value="enkelliste">Enkel liste</option>
			<option value="flislagt">Flislagt</option>
			<option value="rss">RSS</option>
			<option value="karusell">Karusell</option>
		</select></td>
		</tr>

		<tr>
		<td><label for="makstreff">Hvor mange treff skal vi maksimalt hente fra hver base?</label></td>
		<td><select name="makstreff">
			<option value="5">5</option>
			<option value="10">10</option>
			<option value="15" selected>15</option>
			<option value="20">20</option>
			<option value="25">25</option>
		</select></td>
		</tr>

		<tr>
		<td><label for="sortering">Hvordan skal vi sortere disse treffene?</label></td>
		<td><select name="sortering">
			<option value="base" selected>Etter kilde</option>
			<option value="tittel_asc">Tittel A-Å</option>
			<option value="tittel_desc">Tittel Å-A</option>
			<option value="digidato_asc">Registreringsdato, stigende</option>
			<option value="digidato_desc">Registreringsdato, synkende</option>
			<option value="dato_asc">Datering, stigende</option>
			<option value="dato_desc">Datering, synkende</option>
			<option value="ansvar_asc">Ansvarsangivelse A-Å</option>
			<option value="ansvar_desc">Ansvarsangivelse Å-A</option>
			<option value="tilfeldig">Stokk resultatene tilfeldig hver gang</option>
		</select></td>
		</tr>
		</table>	

	    </form>

		</p>

		<h3>Shortcode til å lime inn i innlegg eller på sider</h3>

		<div id="ferdigshortcode">(Shortcode dukker opp her når du foretar et valg)</div>
		
</div>
