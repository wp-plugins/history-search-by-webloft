=== WL Kulturs&oslash;k ===
Contributors: sundaune
Tags: Webekspertene, Aviser, Bilder, lokalhistorie, slektsgransking, slektsgranskning, PDF, Nasjonalbiblioteket, Bøker, bok, bygdehistorie, bygdebok, bygdebøker, historie, norvegiana, kulturnett, webløft, webloft, bibvenn, Bibliotekarens beste venn, kultur, kultursøk, norvegiana
Requires at least: 4.0
Tested up to: 4.1
Stable tag: 2.1
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Find historical material from free Norwegian sources. Norwegian: Finn lokalhistorisk materiale som bøker, bilder etc. fra diverse gratis kilder.

== Description ==

This plugin searches for culture related objects from many freely available Norwegian sources: Books, digital stories, photos, video, audio and more. Upon activation the plugin installs a shortcode available for pages and posts. Using this shortcode will insert a search form - the maximum number of hits to retreieve from each source is specified as arguments to the shortcode. When searching, each search will get its own unique URL for sharing with others. 

NORWEGIAN:

Denne utvidelsen søker i kulturrelatert materiale fra mange fritt tilgjengelige norske kilder: Bøker, digitale fortellinger, bilder, video lyd og annet. Når utvidelsen aktiveres installerer den en kortkode (shortcode) som du kan sette inn i sider og innlegg for å vise en søkeboks. I kortkoden kan det angis hvor mange treff som maksimalt skal hentes fra hver kilde. Hvert søk vil få sin egen unike URL slik at det kan deles med andre. 

== Installation ==

= Uploading the plugin via the Wordpress control panel = 

Make sure you have downloaded the .zip file containing the plugin. Then:

1. Go to 'Add' on the plugin administration panel
2. Proceed to 'Upload'
3. Choose the .zip file on your local drive containing the plugin
4. Click 'Install now'
5. Activate the plugin from the control panel

= Upload the plugin via FTP =

Make sure you have downloaded the .zip file containing the plugin. Then:

1. Unzip the folder 'wl-kultursok' to your local drive
2. Upload the folder 'wl-kultursok' to the '/wp-content/plugins/' folder (or wherever you store your plugins)
3. Activate the plugin from the control panel

= Or install it via the Wordpress repository! =

To place the search form in your post/page, simply insert this shortcode:

[wl-kultursok]

This is the simplest way. There is an optional parameter you can pass along:

* makstreff : Maximum number of hits to retrieve from each source. Default is 25.

Example of shortcode to insert a search form and fetch a maximum of 30 hits from each source:

[wl-kultursok makstreff="30"]

Note that the search form can be styled to your liking by overruling the CSS included with the plugin. 

NORWEGIAN:

= Laste opp innstikket i kontrollpanelet for Wordpress =

Sørg for at du har lastet ned ZIP-filen som inneholder innstikket. Deretter:

1. Gå til 'Legg til' på administrasjonssiden for innstikk
2. Gå til 'Last opp'
3. Velg ZIP-filen som inneholder innstikket på harddisken din
4. Klikk 'Installer nå'
5. Aktiver innstikket fra kontrollpanelet

= Laste opp innstikket via FTP =

Sørg for at du har lastet ned ZIP-filen som inneholder innstikket. Deretter:

1. Pakk ut mappen 'wl-kultursok' til datamaskinen din
2. Last opp mappen 'wl-kultursok' til '/wp-content/plugins/'-katalogen under din Wordpress-installasjon
3. Aktiver innstikket fra kontrollpanelet

= Eller installér det via Wordpress-katalogen! =

For å sette inn søkeboksen på siden eller i innleget ditt, bruk følgende kortkode:

[wl-kultursok]

Dette er den enkleste måten. Det er også en valgfri parameter du kan bruke:

* makstreff : Maks. antall treff å hente fra hver kilde. Standardverdi er 25, maks er 100.

Her er et eksempel som setter inn en søkeboks og henter maks. 30 treff fra hver kilde:

[wl-kultursok makstreff="30"]

Du kan også bestemme i detalj hvordan søkeboksen skal se ut ved å redigere den medfølgende CSS-filen.

== Frequently Asked Questions ==

= Why are there no frequently asked questions? =

Because the plugin is so new that no question has had the chance to become frequent yet!

NORWEGIAN:

= Hvorfor er det ingen Ofte Stilte Spørsmål? =

Fordi dette er første versjon - spørsmålene kommer nok etter hvert.

== Screenshots ==

1. This is what your query result could look like
2. Here is the shortcode as it appears on a page or in a post

NORWEGIAN:

1. Slik kan trefflisten din se ut
2. Slik setter du inn kortkoden i sider eller innlegg

== Change log ==

= 2.1 = 

* New source: Local photo collections (Deichman)
* Bugfix: Didn't display anything when no hits were found
* New display modes for search results: Tiles, simple list and carousel view
* Can now sort results by source, title or random order

= 2.0.1 = 

* Bugfix: Gracefully handles the case where we haven't selected any sources to search

= 2.0 =

Major rewrite.

* Code cleanup to avoid functions conflicting with other plugins
* Now fetches book covers from Webloft's own server
* No longer search-as-you-type
* Module-based system for adding new sources
* Added several new sources: Bærumkunst, Askerbilder, Bærumbilder, Digitalt fortalt, Digitalt Museum 
* Removed NB newspapers as a source
* Added error handling for cases where we don't get a decent result (broken XML, timeouts...)
* Each search now gets its own permalink (URL)

= 1.0.5 =

* Hitting Enter no longer opens a new window - you have to click the button
* Removed superfluous widget code

= 1.0.4 =

* Corrected errors in readme.txt
* Uploaded new screenshot
 
= 1.0.3 = 

* Bugfix: header text not respecting specified width
* Various cosmetic improvements

= 1.0.2 =

* Improved and more readable readme.txt

= 1.0.1 =

* Fixed various errors

= 1.0 =

* First version

NORWEGIAN:

= 2.1 = 

* Ny base: Lokalhistoriske bildebaser i Oslo (Deichman)
* Bugfix: Ga ingen beskjed ved ingen treff
* Nye visninger av treffliste: Flislagt, enkel liste og karusell
* Mulighet for å sortere treffliste etter base, etter tittel eller tilfeldig rekkefølge

= 2.0.1 = 

* Bugfix: Tar hånd om tilfeller der vi ikke har valgt noen baser å søke i

= 2.0 =

Stor overhaling

* Rydding i kode for å unngå at funksjoner kommer i konflikt med andre utvidelser
* Henter nå omslagsbilder fra Webløfts egen server
* Søker ikke lenger automatisk mens du skriver
* Modulbasert innlegging av nye søkekilder
* Lagt til mange nye søkekilder: Bærumkunst, Askerbilder, Bærumbilder, Digitalt fortalt, Digitalt Museum 
* Fjernet aviser fra Nasjonalbiblioteket som søkekilde
* Mulighet for å lenke direkte til søk

= 1.0.5 = 

* Trykk på Enter åpner ikke lenger nytt vindu, du må klikke på knappen
* Fjernet overflødig widgetkode

= 1.0.4 =

* Rettet feil i readme.txt
* Tok nytt skjermskudd

= 1.0.3 =

* Bugfix: Angitt bredde ble ikke respektert i overskriftstekst
* Forskjellige kosmetiske forbedringer

= 1.0.2 =

* Bedre og mer forståelig readme.txt

= 1.0.1 =

* Fikset forskjellig småtteri

= 1.0 =

* Første versjon

== Upgrade Notice ==

No upgrade notive at this point

NORWEGIAN:

Ingen beskjeder
