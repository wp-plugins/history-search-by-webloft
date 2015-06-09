<?php

$lokalhistbaser = get_option('lokalhist_option_baser' , '');

?>
<div class="wrap">

    <h1>WL Kultursøk - innstillinger</h1>

    <form method="post" action="options.php">

        <?php settings_fields('lokalhist_options'); ?>

        <h3>Baser å ha med</h3>

        <p>
		Bokhylla (emne lokalhistorie):&nbsp;
		<input name="lokalhist_option_baser[]" type="checkbox" value="bokhylla|x|Bokhylla" <?php if (in_array('bokhylla|x|Bokhylla' , $lokalhistbaser)) { echo "checked";} ?> />
		<?php merbaseinfo ("http://www.nb.no/Tilbud/Samlingen/Samlingen/Boeker/Bokhylla.no"); ?>
		<br>

		Bilder fra Nasjonalbiblioteket:&nbsp;
		<input name="lokalhist_option_baser[]" type="checkbox" value="nbbilder|x|Bilder fra NB" <?php if (in_array('nbbilder|x|Bilder fra NB' , $lokalhistbaser)) { echo "checked";} ?> />
		<?php merbaseinfo ("http://www.nb.no/Tilbud/Samlingen/Samlingen/Bilder"); ?>
		<br>

		Lokalhistoriewiki:&nbsp;
		<input name="lokalhist_option_baser[]" type="checkbox" value="lokalhistoriewiki|x|Lokalhistoriewiki" <?php if (in_array('lokalhistoriewiki|x|Lokalhistoriewiki' , $lokalhistbaser)) { echo "checked";} ?> />
		<?php merbaseinfo ("https://lokalhistoriewiki.no/index.php/Hjelp:Om_wikien"); ?>
		<br>

		Norvegiana (alle baser):&nbsp;
		<input name="lokalhist_option_baser[]" type="checkbox" value="norvegianaalle|x|Norvegiana (alle)" <?php if (in_array('norvegianaalle|x|Norvegiana (alle)' , $lokalhistbaser)) { echo "checked";} ?> />
		<?php merbaseinfo ("http://no.wikipedia.org/wiki/Norvegiana_API"); ?>
		<br>

		Norvegiana (Digitalt fortalt):&nbsp;
		<input name="lokalhist_option_baser[]" type="checkbox" value="norvegianadifo|x|Norvegiana (Digitalt fortalt)" <?php if (in_array('norvegianadifo|x|Norvegiana (Digitalt fortalt)' , $lokalhistbaser)) { echo "checked";} ?> />
		<?php merbaseinfo ("http://digitaltfortalt.no/info/about"); ?>
		<br>

		Norvegiana (Digitalt Museum):&nbsp;
		<input name="lokalhist_option_baser[]" type="checkbox" value="norvegianadimu|x|Norvegiana (Digitalt Museum)" <?php if (in_array('norvegianadimu|x|Norvegiana (Digitalt Museum)' , $lokalhistbaser)) { echo "checked";} ?> />
		<?php merbaseinfo ("https://digitaltmuseum.no/info/digitaltmuseum"); ?>
		<br>

		B&aelig;rum biblioteks kunstbase:&nbsp;
		<input name="lokalhist_option_baser[]" type="checkbox" value="baerumkunst|x|Bærum biblioteks kunstbase" <?php if (in_array('baerumkunst|x|Bærum biblioteks kunstbase' , $lokalhistbaser)) { echo "checked";} ?> />
		<?php merbaseinfo ("http://bibliotek.baerum.kommune.no/Nyheter/Kunstsamling/"); ?>
		<br>

		B&aelig;rum biblioteks bildebase:&nbsp;
		<input name="lokalhist_option_baser[]" type="checkbox" value="baerumbilder|x|Bærum biblioteks bildebase" <?php if (in_array('baerumbilder|x|Bærum biblioteks bildebase' , $lokalhistbaser)) { echo "checked";} ?> />
		<?php merbaseinfo ("http://bibliotek.baerum.kommune.no/lokalhistorie/Bilder-fra-Barum/Lokalhistoriske-bilder/"); ?>
		<br>

		Asker biblioteks bildebase:&nbsp;
		<input name="lokalhist_option_baser[]" type="checkbox" value="askerbilder|x|Asker biblioteks bildebase" <?php if (in_array('askerbilder|x|Asker biblioteks bildebase' , $lokalhistbaser)) { echo "checked";} ?> />
		<?php merbaseinfo ("http://www.askerbibliotek.no/askersamling/bilder/"); ?>
		<br>

<?php

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

        <p class="submit">
            <input type="submit" class="button-primary" value="Oppdat&eacute;r" />
        </p>

    </form>
</div>
