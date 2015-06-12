<?php

/**
 *
 * @package   WL Kulturs�k
 * @author    H&aring;kon Sundaune / Bibliotekarens beste venn <haakon@bibliotekarensbestevenn.no>
 * @license   GPL-3.0+
 * @link      http://www.bibvenn.no
 * @copyright 2015 H�kon M. E. Sundaune
 *
 * @wordpress-plugin
 * Plugin Name:       WL Kulturs&oslash;k
 * Plugin URI:        http://www.bibvenn.no/
 * Description:       S&oslash;ker etter lokalhistorisk materiale / search for historical material (books, images, video, audio...)
 * Version:           2.0.1
 * Author:            H&aring;kon Sundaune / Bibliotekarens beste venn
 * Author URI:        http://www.bibvenn.no/
 * Text Domain:       wl-kultursok-locale
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Domain Path:       /languages
 * WordPress-Plugin-Boilerplate: v2.6.1
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// INCLUDE NECESSARY  
    
    add_action( 'wp_enqueue_scripts', 'finnlokalhistorie_safely_add_stylesheets_and_scripts' );
	require_once("includes/functions.php"); // funksjoner vi har bruk for

    /**
     * Add stylesheet to the page
     */
    function finnlokalhistorie_safely_add_stylesheets_and_scripts() {
		wp_enqueue_script('finnlokalhist-public', plugins_url( 'js/public.js', __FILE__ ), array('jquery') );
		$visning = get_option('lokalhist_option_visning', 'trekkspill');
	    wp_enqueue_style( 'finnlokalhistorie-shortcode-style', plugins_url('/css/public.css', __FILE__) );
		if ($visning == "trekkspill") {
			wp_enqueue_script('finnlokalhist-accordion', plugins_url( 'js/accordion.js', __FILE__ ), array('jquery') );
			wp_enqueue_script('finnlokalhist-accordion-init', plugins_url( 'js/accordion_init.js', __FILE__ ), array('jquery') );
		}

		if ($visning == "flislagt") {
			wp_enqueue_script('finnlokalhist-masonry', plugins_url( 'js/masonry.pkgd.min.js', __FILE__ ), array('jquery') );
			wp_enqueue_script('finnlokalhist-masonry-imagesload', plugins_url( 'js/imagesloaded.pkgd.min.js', __FILE__ ), array('jquery') );
			wp_enqueue_script('finnlokalhist-masonry-init', plugins_url( 'js/masonry-init.js', __FILE__ ), array('jquery') );
		}
    }

// FIRST COMES THE SHORTCODE... EH, CODE!

function finnlokalhistorie_func ($atts){

extract(shortcode_atts(array(
	'makstreff' => "25"
   ), $atts));

// DEFINE HTML TO OUTPUT WHEN SHORTCODE IS FOUND 

$width = "98%"; // ikke lenger width som parameter
$lokalhistmakstreff = (int) $makstreff;

if ((isset($_REQUEST['lokalhistquery'])) && (trim($_REQUEST['lokalhistquery']) != '')) {
	$querystring = trim(strip_tags(stripslashes($_REQUEST['lokalhistquery'])));
} else {
	$querystring = '';
}

@$oldargs = stristr (get_permalink ($post->id) , "?"); // alt etter ? er query vars
$oldargs = str_replace ("?" , "" , $oldargs);
$oldargs = wp_parse_args ($oldargs);

@$formaction = stristr (get_permalink ($post->id) , "?" , TRUE); // alt F�R ? er basis
$formaction = str_replace ("?" , "" , $formaction);

$htmlout = '';
$htmlout .= '<div class="lokalhistorie_skjema" style="width: ' . $width . '">';
$htmlout .= '<form method="GET" action="' . $formaction . '">';

$htmlout .= '<input type="text" name="lokalhistquery" value="' . $querystring . '" placeholder="S&oslash;k etter..." />';
$htmlout .= '<input type="submit" value="S&oslash;k">';

// Legge til de som finnes fra f�r
foreach ($oldargs as $key => $value) {
	$htmlout .= '<input type="hidden" name="' . $key . '" value="' . $value . '">' . "\n";
}

$htmlout .= '<br style="clear: both;">';
$htmlout .= '</form>';
$htmlout .= '</div>';

if ($querystring != '') {

	ob_start();
	include "search.php";
	$result = ob_get_contents();
	$htmlout .= $result;
	ob_end_clean();


} else {
	// Ingen treff, ingen kake
	$htmlout .= '';
}

return $htmlout;

}; // end function
 
add_shortcode("finnlokalhistorie_skjema", "finnlokalhistorie_func");
add_shortcode("wl-kultursok", "finnlokalhistorie_func");

// Settings page

add_action('admin_menu', 'lokalhist_setuppage');
add_action('admin_init', 'lokalhist_registersettings');

function lokalhist_setuppage() {
    add_options_page("WL Kulturs&oslash;k", "WL Kulturs&oslash;k", "manage_options", "lokalhist_options", "lokalhist_settings_page");
}

function lokalhist_registersettings() {
    // Add options to database if they don't already exist
    add_option("lokalhist_option_baser", "", "", "yes");
    add_option("lokalhist_option_visning", "trekkspill", "", "yes");

    // Register settings that this form is allowed to update
    register_setting('lokalhist_options', 'lokalhist_option_baser');
    register_setting('lokalhist_options', 'lokalhist_option_visning');
}

function lokalhist_settings_page() {
    if (!current_user_can('manage_options'))
        wp_die(__("You don't have access to this page"));
	require dirname(__FILE__) . '/includes/settings.php';
}

