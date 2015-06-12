<?php

$lokalhistbaser = (array) get_option('lokalhist_option_baser' , '');

$visning = get_option('lokalhist_option_visning' , 'trekkspill');

?>
<div class="wrap">

    <h1>WL Kultursøk - innstillinger</h1>

    <form method="post" action="options.php">

        <?php settings_fields('lokalhist_options'); ?>

        <h3>Baser å ha med</h3>

        <p>

		<?php
		require_once ("basenavn.php");
		foreach ($basenavn as $enbase) {
			$splitt = explode ("|x|" , $enbase);
			echo $splitt[1] . "&nbsp";
			echo '<input name="lokalhist_option_baser[]" type="checkbox" value="' . $splitt[0] . '"';
			if (in_array($splitt[0] , $lokalhistbaser)) { echo "checked";}
			echo " />";
			merbaseinfo ($splitt[2]);
			echo "<br>\n\n";
		}

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
<!--
		<h3>Utseende</h3>
		<p>

		<label for="lokalhist_option_visning">Hvordan skal vi vise trefflisten?</label>&nbsp;
		<select name="lokalhist_option_visning">
		<option value="trekkspill" <?php if ($visning == 'trekkspill') { echo "selected"; } ?>>Trekkspill</option>
		<option value="enkelliste" <?php if ($visning == 'enkelliste') { echo "selected"; } ?>>(Enkel liste)</option>
		<option value="flislagt" <?php if ($visning == 'flislagt') { echo "selected"; } ?>>Flislagt</option>
		<option value="slideshow" <?php if ($visning == 'slideshow') { echo "selected"; } ?>>(Slideshow)</option>
		<option value="rss" <?php if ($visning == 'rss') { echo "selected"; } ?>>(RSS)</option>
		
		</select>
		<br><br><i>Valgene i parentes er ikke implementert ennå...</i>
		</p>

		<h3>Shortcode</h3>
		<p>
		<i>(Oppdateres når du lagrer innstillingene)</i><br><br>
		<strong>[wl-kultursok baser="<?= implode("," , $lokalhistbaser) ?>" visning="<?= $visning ?>"]</strong>
		</p>
-->
        <p class="submit">
            <input type="submit" class="button-primary" value="Oppdat&eacute;r" />
        </p>

    </form>
</div>
