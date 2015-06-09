<?php

if (!function_exists('domp')) {
	function domp ($whattodomp) {
		echo "<pre>";
		print_r ($whattodomp);
		echo "</pre>";
	}
}

if (!function_exists('rop')) {
	function rop ($whattorop) {
		echo "<h1>*" . $whattorop . "*</h1>";
	}
}

if (!function_exists('get_content')) {
	function get_content($url) { 
	
		$ch = curl_init();  
	     
		curl_setopt ($ch, CURLOPT_URL, $url);  
		curl_setopt ($ch, CURLOPT_HEADER, 0);  
	      
		ob_start();  
	      
		curl_exec ($ch);  
		curl_close ($ch);  
		$string = ob_get_contents();  
	      
		ob_end_clean();  
	         
		return $string;
	}  
}

if (!function_exists('trunc')) {
	function trunc($phrase, $max_words) {
	   $phrase_array = explode(' ',$phrase);
	   if(count($phrase_array) > $max_words && $max_words > 0)
	      $phrase = implode(' ',array_slice($phrase_array, 0, $max_words)).'...';
	   return $phrase;
	}
}

function merbaseinfo ($lenke) { // Viser lenke til mer info om en base
 echo '[<a target="_blank" href="' . $lenke . '">mer info</a>]';
}

?>
